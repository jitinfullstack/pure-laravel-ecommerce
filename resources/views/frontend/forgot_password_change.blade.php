@extends('frontend.layouts')
@section('page_title', 'Forgot Password ')
@section('container')

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
                 <h4>Change Password</h4>
                 <form class="aa-login-form" id="frmUpdatePassword">

                    <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password" required>
                    <div id="password_error" class="field_error"></div>

                    <button type="submit" class="aa-browse-btn" id="btnUpdatePassword">Update Password</button>
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
