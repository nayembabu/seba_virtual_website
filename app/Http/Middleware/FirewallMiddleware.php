<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FirewallMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Check if the IP is blocked (Implement your own logic here)
        // $this->is_ip_blocked($ip);

        // Known User-Agent strings for scanning tools
        $banned_user_agents = [
            'sqlmap', 'dirbuster', 'nmap', 'nikto', 'wpscan', 'fuzz', 'whatweb',
        ];

        $user_agent = strtolower($request->userAgent() ?? '');

        foreach ($banned_user_agents as $banned_agent) {
            if (strpos($user_agent, $banned_agent) !== false) {
                $this->block_request('Malicious scanning tool detected!', $ip);
            }
        }

        // Detect SQL injection attempts using regex patterns
        $sql_injection_patterns = [
            '/union\s+select/i',
            '/select\s+\*\s+from/i',
            '/drop\s+table/i',
            '/\'\s*or\s*\'1\'\s*=\s*\'1\'/i',
            '/--/i', '/#/', '/\/\*/',
            '/\b(select|insert|update|delete|drop|union|or)\b/i', // Broader SQL keywords
        ];

        // Check all parameters (GET and POST)
        $params = array_merge($request->query(), $request->post());

        foreach ($params as $param) {
            foreach ($sql_injection_patterns as $pattern) {
                if (preg_match($pattern, $param)) {
                    $this->block_request('SQL Injection attempt detected!', $ip);
                }
            }
        }

        // Detect suspicious User-Agents
        $suspicious_agents = ['', '', 'bot', 'scanner', 'python-requests'];
        foreach ($suspicious_agents as $agent) {
            if (strpos($user_agent, $agent) !== false) {
                $this->block_request('Suspicious User-Agent detected.', $ip);
            }
        }

        // Continue processing the request if no issues found
        return $next($request);
    }

    /**
     * Block the request and log the action.
     *
     * @param  string  $message
     * @param  string  $ip
     * @return void
     */ 
    protected function block_request($message, $ip)
    {
        // Log the block action
        Log::warning("Blocked Request: {$message} from IP: {$ip}");

        // Return a response (you can customize this)
        abort(403, 'Access forbidden. Your request has been logged.');
    }

    /**
     * Check if the IP is blocked (implement your own logic).
     *
     * @param  string  $ip
     * @return void
     */
    protected function is_ip_blocked($ip)
    {
        // Example: Block specific IP addresses
        $blocked_ips = [
            '192.169.1.1', // Add your blocked IPs here
            // Add more IPs as needed
        ];

        if (in_array($ip, $blocked_ips)) {
            abort(403, 'Your IP has been blocked.');
        }
    }
}
