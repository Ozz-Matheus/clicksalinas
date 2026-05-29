@extends('layout')

@section('meta-title', 'Terms and Conditions : ' . config('app.name'))
@section('meta-description', 'Terms and Conditions for booking photography sessions with Click Salinas.')

@section('content')
<div class="container section_pt-large section_pb-large">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="h2 mb-4">Terms and Conditions</h1>

            <h2 class="h4 mt-4">1. Services</h2>
            <p>Click Salinas provides professional photography services in Cartagena de Indias, Colombia. By booking a session, you agree to the terms outlined in your specific photography contract.</p>

            <h2 class="h4 mt-4">2. Bookings and Cancellations</h2>
            <p>A deposit may be required to secure your date. Cancellation policies, including deposit refunds and rescheduling options, will be clearly communicated before your booking is finalized.</p>

            <h2 class="h4 mt-4">3. Copyright and Image Use</h2>
            <p>Carlos Hernandez Salinas retains the copyright to all images. Clients are granted a license for personal, non-commercial use of the delivered photographs. We reserve the right to use selected images for promotional purposes on our website and social media, unless the client explicitly requests a private session.</p>

            <h2 class="h4 mt-4">4. Governing Law</h2>
            <p>These terms shall be governed by and construed in accordance with the laws of Colombia.</p>
        </div>
    </div>
</div>
@stop