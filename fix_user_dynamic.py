import sys

filepath = "/var/www/website/app/Http/Controllers/User/HomeController.php"

with open(filepath, "rb") as f:
    content_bytes = f.read()

newline = '\r\n' if b'\r\n' in content_bytes else '\n'
content = content_bytes.decode('utf-8')

# 1. Update manualRecharge() to pass gateways
old1 = (
    '    public function manualRecharge()' + newline +
    '    {' + newline +
    '        $data[\'user\'] = $this->user;' + newline +
    '        $data[\'recharges\'] = Recharge::where(\'user_id\', auth()->user()->id)->whereIn(\'gateway_id\', [\'bKash\',\'Nagad\',\'Rocket\'])->where(\'created_at\', \'>=', now()->subHours(24))->orderBy(\'created_at\',\'desc\')->paginate(5);' + newline +
    '        return view(\'user.manual-recharge\', $data);' + newline +
    '    }'
)

new1 = (
    '    public function manualRecharge()' + newline +
    '    {' + newline +
    '        $data[\'user\'] = $this->user;' + newline +
    '        $data[\'gateways\'] = Gateway::where(\'status\', 1)->get();' + newline +
    '        $activeNames = $data[\'gateways\']->pluck(\'name\')->toArray();' + newline +
    '        $data[\'recharges\'] = Recharge::where(\'user_id\', auth()->user()->id)->whereIn(\'gateway_id\', $activeNames)->where(\'created_at\', \'>=', now()->subHours(24))->orderBy(\'created_at\',\'desc\')->paginate(5);' + newline +
    '        return view(\'user.manual-recharge\', $data);' + newline +
    '    }'
)

# 2. Update manualRechargeProcess() validation to be dynamic
old2 = (
    "        \$request->validate([" + newline +
    "            'amount' => 'required|numeric|min:100'," + newline +
    "            'method' => 'required|in:bKash,Nagad,Rocket'," + newline +
    "        ]);"
)

new2 = (
    "        \$activeMethods = Gateway::where('status', 1)->pluck('name')->implode(',');" + newline +
    "        \$request->validate([" + newline +
    "            'amount' => 'required|numeric|min:100'," + newline +
    "            'method' => 'required|in:' . \$activeMethods," + newline +
    "        ]);"
)

# 3. Update manualRechargePay() validation
old3 = "if (!in_array($method, ['bKash', 'Nagad', 'Rocket'])) {"
new3 = "if (!Gateway::where('name', $method)->where('status', 1)->exists()) {"

# 4. Update manualRechargeSubmit() validation  
old4 = "        if (!in_array($method, ['bKash', 'Nagad', 'Rocket'])) {"
new4 = "        if (!Gateway::where('name', $method)->where('status', 1)->exists()) {"

changes = 0

for old, new in [(old1, new1), (old2, new2), (old3, new3), (old4, new4)]:
    if old in content:
        content = content.replace(old, new)
        changes += 1
        print(f"Replaced: {old[:60]}...")
    else:
        print(f"NOT FOUND: {old[:60]}...")

with open(filepath, "w", encoding="utf-8") as f:
    f.write(content)

print(f"\nTotal changes: {changes}")
