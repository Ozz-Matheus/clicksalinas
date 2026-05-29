@extends('layout')

@section('meta-title', 'Privacy Policy : ' . config('app.name'))
@section('meta-description', 'Privacy Policy and data protection terms for Click Salinas Photography in Cartagena de Indias.')

@section('content')
<div class="container section_pt-large section_pb-large">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="h2 mb-4">Privacy Policy</h1>
            <p><strong>Last Updated: {{ now()->format('F Y') }}</strong></p>

            <p>At Click Salinas ("we", "our", or "us"), we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information when you visit our website (clicksalinas.com) or use our photography services in Cartagena de Indias, Colombia, in compliance with Colombian Law 1581 of 2012 and international standards.</p>

            <h2 class="h4 mt-4">1. Information We Collect</h2>
            <p>We may collect personal identification information, including but not limited to your name, email address, and phone number, solely when you voluntarily submit it through our contact forms to book a photography session or request a quote.</p>

            <h2 class="h4 mt-4">2. How We Use Your Data</h2>
            <p>The information we collect is used exclusively to: communicate with you regarding your booking, provide our photography services, and improve our website's user experience.</p>

            <h2 class="h4 mt-4">3. Cookies and Analytics</h2>
            <p>Our website uses Google Analytics to understand how visitors interact with our site. These cookies collect non-personally identifying information such as browser type, referring site, and the date and time of each visitor request.</p>

            <h2 class="h4 mt-4">4. Data Retention and Your Rights</h2>
            <p>We do not sell, trade, or rent your personal information to third parties. You have the right to access, correct, or request the deletion of your personal data at any time by contacting us.</p>

            <h2 class="h4 mt-4">5. Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at: <strong>hi@clicksalinas.com</strong></p>
        </div>
    </div>
</div>
@stop