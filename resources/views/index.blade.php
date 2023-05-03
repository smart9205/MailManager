@extends('layouts.app')

@section('content')
    <section class="home py-5 d-flex align-items-center" id="header">
        <div class="container text-light py-5"> 
            <h1 class="headline">Mail <br/> <span class="home_text">Service System</h1>
            {{-- <h5 class="para para-light py-3">Talk to a Therapist from the comfort of your home</h5> --}}            
            <div class="d-flex align-items-center">
                <p class="p-2"><i class="fas fa-laptop-house fa-lg"></i></p>
                <p>Choose your preferred mode of chatting.</p>  
            </div>
            <div class="d-flex align-items-center">
                <p class="p-2"><i class="fas fa-wifi fa-lg"></i></p>
                <p>Chat with your employee.</p>  
            </div>
            {{-- <div class="my-3 d-flex justify-content-start">
                <a class="btn mx-3" href="register">Get Started</a>
                <a class="btn-reverse mx-3" href="#">Why HCS?</a>
            </div> --}}
            
        </div>
    </section>
@endsection