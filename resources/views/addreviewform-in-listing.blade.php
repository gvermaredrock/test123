@if(Auth::check() && auth()->user()->reviews->where('listing_id',$listing->id)->count())
    <div class="alert alert-danger">You provided a review of this listing! Thanks.</div>
@elseif (Auth::check() && $listing->user_id && $listing->user_id == auth()->id())
    <div class="alert alert-danger">You cannot review your own listing. You can reply back to others' comments <a href="{{config('my.APP_URL')}}/managecomments">here</a> </div>
@else
    <div class="alert alert-danger" v-show="reviewprovided" >You provided a review of this listing! Thanks.</div>
    <div class="bg-light p-4 border" v-show="!reviewprovided">
        <h3 class="mb-4">Any enquiries or General Comments? Just write below - we'll reach out to the business owner and try to get them answered.</h3>
        <form @submit.prevent="createreview" v-show="showingreviewform">
            <div class="form-row">
                @guest
                    <div class="col-12 col-md-4 mb-sm-3">
                        <div class="form-group">
                            <label class="input-label">Name</label>
                            <input type="text" class="form-control" ref="user_name" name="user_name" id="inputName" placeholder="Name" aria-label="Name" required="required" @auth
                            @if(auth()->user()->name == (auth()->user()->phone).'@wuchna.com')  value="Verified User"
                                   @else
                                   value="{{auth()->user()->name}}"
                                   @endif
                                   disabled
                                @endauth>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-sm-3">
                        <div class="form-group">
                            <label class="input-label">Email</label>
                            <input type="email" class="form-control" name="user_email" ref="user_email" id="user_email" placeholder="Email Address" aria-label="Email Address" required="required" @auth @if(auth()->user()->email) disabled value="{{auth()->user()->email}}" @endif  @endauth>
                        </div>
                    </div>
                @endguest
                <div class="col-12 col-md-3 ml-3 mb-sm-3">
                    <div class="form-group">
                        <label class="input-label">Rating</label>
                        <br>
                        <div>
                        <svg width="32" @click="ratingStar(1)" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" xml:space="preserve"><path d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z" ref="star1" class="st0"></path></svg>
                        <svg width="32" @click="ratingStar(2)" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" xml:space="preserve"><path d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z" ref="star2" class="st0"></path></svg>
                        <svg width="32" @click="ratingStar(3)" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" xml:space="preserve"><path d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z" ref="star3" class="st0"></path></svg>
                        <svg width="32" @click="ratingStar(4)" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" xml:space="preserve"><path d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z" ref="star4" class="st0"></path></svg>
                        <svg width="32" @click="ratingStar(5)" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" xml:space="preserve"><path d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z" ref="star5" class="st1"></path></svg>
                        </div>
                        <input type="hidden" ref="rating" name="rating">
                    </div>
                </div>
                <div class="col-12 mb-sm-3" v-pre>
                    <div class="form-group">
                        <label class="input-label">Review</label>
                        <div id="standalone-container">
                            <div id="editor" style="height: 86px">
                            </div>
                        </div>
                        <textarea class="d-none" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-wide transition-3d-hover">Submit</button>
            </div>
        </form>
        <form @submit.prevent="reviewotpsubmit" v-show="showingreviewotpform">
            <label for="reviewotp" class="small">Enter OTP received at email:</label>
            <input ref="reviewotp" type="text" id="reviewotp" name="reviewotp" placeholder="Enter OTP received at email" required class="form-control"/>
            <label class="text-danger">Unverified reviews will be deleted !!</label>
            <button class="btn btn-secondary btn-sm float-right mt-2" type="submit">Submit</button>
        </form>

    </div>
@endif
