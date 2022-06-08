@extends('frontend.layouts')
{{-- @section('page_title', 'Daily Shop | '.$product->name ) --}}
@section('page_title', 'Account ')
@section('container')

<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="{{ asset('frontend_assets/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Account Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>
          <li class="active">Account</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">
            <div class="row">

              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="aa-myaccount-register">
                 <h4>Register</h4>
                 <form class="aa-login-form" id="frmRegistration">
                    <label for="">Name<span>*</span></label>
                    <input type="text" name="name" placeholder="Name" required>
                    <div id="name_error" class="field_error"></div>

                    <label for="">Email<span>*</span></label>
                    <input type="email" name="email" placeholder="Email" required>
                    <div id="email_error" class="field_error"></div>

                    <label for="">Mobile<span>*</span></label>
                    <input type="text" name="mobile" placeholder="Mobile" required>
                    <div id="mobile_error" class="field_error"></div>

                    <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password">
                    <div id="password_error" class="field_error"></div>

                    <button type="submit" class="aa-browse-btn" id="btnRegistration">Register</button>
                    @csrf
                  </form>
                </div>
                &nbsp;
                <div id="thank_you_msg" class="field_error"></div>
              </div>
              <div class="col-md-2"></div>
            </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

@endsection
