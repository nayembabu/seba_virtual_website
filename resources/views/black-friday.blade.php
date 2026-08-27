<!-- resources/views/black-friday.blade.php -->
@extends('layouts.app')
@section('title', 'Black Friday')
@section('black-friday', 'active')
@section('content')
<style>
    .black-friday-page {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        flex: 1 0 auto;
        height: 100vh;
        position: relative;
        background-color: #f7f7f7;
    }

    .background {
        background: url('/black-friday-background.png') no-repeat bottom;
        background-size: 100%;
        position: absolute;
        width: 100%;
        height: 100%;
        bottom: 0;
        z-index: -2;
    }

    .header {
        text-align: center;
        padding: 50px 0;
        background-color: #000;
        color: #fff;
        width: 100%;
        z-index: 1;
    }

    .header h1 {
        font-size: 3em;
        margin: 0;
    }

    .header p {
        font-size: 1.5em;
        margin: 10px 0 0;
    }

    .deal {
        background-color: #fff;
        padding: 20px;
        margin: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
        z-index: 1;
    }

    .promo-code {
        background-color: #000;
        color: #fff;
        padding: 10px;
        margin: 20px 0;
        display: inline-block;
        cursor: pointer;
        user-select: none;
    }

    .countdown {
        font-size: 2em;
        color: #e74c3c;
        margin: 20px 0;
    }

    .calendar {
        font-size: 1.2em;
        color: #333;
        margin: 20px 0;
        text-align: center;
    }

    .footer {
        text-align: center;
        padding: 20px 0;
        background-color: #333;
        color: #fff;
        position: absolute;
        width: 100%;
        bottom: 0;
        z-index: 1;
    }

    .preloader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        z-index: 9999;
        display: none;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="black-friday-page">
    <div class="background"></div>
    <div class="preloader"></div>
    
    <header class="header">
        <h1>Black Friday Deals</h1>
        <p>Don't miss out on these amazing offers!</p>
    </header>

    <div class="calendar" id="calendar"></div>
    
    <div class="countdown" id="countdown"></div>
    
    <div class="deal">
        <div class="promo-code" onclick="copyPromoCode('ELEC50')">ELEC50 - Click to Copy</div>
    </div>
    
    <footer class="footer">
        <p>&copy; 2024 Black Friday Deals</p>
    </footer>
</div>

<script>
    function getNextFriday() {
        const now = new Date();
        const dayOfWeek = now.getDay();
        const daysUntilNextFriday = (5 - dayOfWeek + 7) % 7 || 7; // If today is Friday, set to 7 days later
        const nextFriday = new Date(now.getFullYear(), now.getMonth(), now.getDate() + daysUntilNextFriday, 0, 0, 0);
        return nextFriday;
    }

    function updateCountdown() {
        const countdownElement = document.getElementById('countdown');
        const nextFriday = getNextFriday();
        const now = new Date();
        const timeDifference = nextFriday - now;

        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

        countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

        if (timeDifference < 0) {
            countdownElement.textContent = "It's Black Friday!";
        }
    }

    function copyPromoCode(code) {
        navigator.clipboard.writeText(code).then(function() {
            alert('Promo code ' + code + ' copied to clipboard');
        }, function(err) {
            alert('Failed to copy promo code: ', err);
        });
    }

    function updateCalendar() {
        const calendarElement = document.getElementById('calendar');
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        calendarElement.textContent = now.toLocaleDateString(undefined, options);
    }

    window.addEventListener('load', function() {
        var preloader = document.querySelector('.preloader');
        preloader.style.display = 'none';
        updateCalendar();
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
@endsection
