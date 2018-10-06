@extends("layouts.sharesite")

@section("main-content")

<div class="container">

	<section style="margin-top: 100px; margin-bottom: 50px;">
		<div class="container">
			@foreach($errors->all() as $error)
				<p class="alert alert-danger">{{ $error }}</p>
			@endforeach
			<div class="row">
				<div class="col-sm-12">
					<h3 class="category-heading">What kind of site do you want to make ?</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-12">
							<div class="choose-category">
								<!--<form id="makeasite" name="makeasite" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}-->
									<div class="row">
										<div class="col-sm-3 category-title">
											<label>Choose site category:</label>
										</div>
										<div class="col-sm-9">
											<ul>
												@foreach($ssc as $k => $v)
												<li>
													<input type="radio" @if($v->id == $id) checked @endif name="site_category" value="{{$v->id}}"> 
													<label>{{$v->title}}</label>
												</li>
												@endforeach
											</ul>
										</div>
									</div>
									
									@foreach($ssc as $h => $v)
									
									@if($v->title == 'Family') 
									<form id="family" name="makeasite" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-4" type="text" name="website_url" required="true">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Sports Teams') 
									<form id="sports_team" name="makeasite1" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Sport:</label>
											<select name="sports">
												<option value="Baseball">Baseball</option>
												<option value="Basketball">Basketball</option>
												<option value="Bowling">Bowling</option>
												<option value="Cheerleading">Cheerleading</option>
												<option value="Cross Country">Cross Country</option>
												<option value="Cycling">Cycling</option>
												<option value="Field Hockey">Field Hockey</option>
												<option value="Football">Football</option>
												<option value="Golf">Golf</option>
												<option value="Gymnastics">Gymnastics</option>
												<option value="Ice-hockey">Ice-hockey</option>
												<option value="Lacrosse">Lacrosse</option>
												<option value="Rowing">Rowing</option>
												<option value="Rugby">Rugby</option>
												<option value="Sailing">Sailing</option>
												<option value="Skiling">Skiling</option>
												<option value="Snowboarding">Snowboarding</option>
												<option value="Soccer">Soccer</option>
												<option value="Softball">Softball</option>
												<option value="Swimming">Swimming</option>
												<option value="Tennis">Tennis</option>
												<option value="Track">Track</option>
												<option value="Volleyball">Volleyball</option>
												<option value="Water Polo">Water Polo</option>
												<option value="Wrestling">Wrestling</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Gender:</label>
											<select name="gender">
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Age range:</label>
											<select name="age_range">
												<option value="Kids (5-10)">Kids (5-10)</option>
												<option value="Kids (10-14)">Kids (10-14)</option>
												<option value="Youth (14-18)">Youth (14-18)</option>
												<option value="Adults (over 18)">Adults (over 18)</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Zip Code</label>
											<input class="col-sm-8" type="text" name="zip_code">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your team:</label>
											<input class="col-sm-8" type="text" name="team_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Classroom') 
									<form id="classroom" name="makeasite2" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Your role:</label>
											<select name="role">
												<option value="role">Teacher</option>
												<option value="role">Student</option>
												<option value="role">Parent</option>
												<option value="role">Others</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Grade:</label>
											<select name="grade">
												<option value="Pre-school">Pre-school</option>
												<option value="Kindergarten">Kindergarten</option>
												<option value="1st">1st</option>
												<option value="2nd">2nd</option>
												<option value="3rd">3rd</option>
												<option value="4th">4th</option>
												<option value="5th">5th</option>
												<option value="6th">6th</option>
												<option value="7th">7th</option>
												<option value="8th">8th</option>
												<option value="9th">9th</option>
												<option value="10th">10th</option>
												<option value="11th">11th</option>
												<option value="12th">12th</option>
												<option value="College/University">College/University</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Events & Celebrations')
									<form id="event" name="makeasite3" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Event type:</label>
											<select name="event_type">
												<option value="Baby Shower">Baby Shower</option>
												<option value="Bachelor Party">Bachelor Party</option>
												<option value="Bachelorette Party">Bachelorette Party</option>
												<option value="Bridal Shower">Bridal Shower</option>
												<option value="Memorial/Celebration of life">Memorial/Celebration of life</option>
												<option value="Birthday">Birthday</option>
												<option value="Charity/Fundraiser">Charity/Fundraiser</option>
												<option value="Party">Party</option>
												<option value="Graduation">Graduation</option>
												<option value="Halloween">Halloween</option>
												<option value="New Year's">New Year's</option>
												<option value="Proffessional Event">Proffessional Event</option>
												<option value="Religion Celebration">Religion Celebration</option>
												<option value="Reunion">Reunion</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Event date:</label>
											<input id="datepicker3" class="col-sm-8" type="text" name="event_date">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Baby') 
									<form id="baby" name="makeasite4" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Baby's birthdate:</label>
											<input id="datepicker" class="col-sm-8" type="text" name="birthdate">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Clubs & Groups') 
									<form id="club" name="makeasite5" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Wedding')
									<form id="wedding" name="makeasite6" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Wedding date:</label>
											<input id="datepicker2" class="col-sm-8" type="text" name="wedding_date">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required">  
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Travel') 
									<form id="travel" name="makeasite7" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Photo Gallery')
									<form id="photogallery" name="makeasite8" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif
									@if($v->title == 'Sports Leagues & Clubs') 
									<form id="sports_leagues" name="makeasite9" method="post" action="{{URL::asset('sharesite/makeasite_post')}}">
									{{csrf_field()}}
									<div class="form-category" id="form_category{{$v->id}}" style="display: @if($v->id==$id)block @else none;@endif">
										<input type="hidden" name="site_category_v" id="site_category" value="{{$v->id}}"/>
										<div class="row form-group category-form">
											<label class="col-sm-3">Name of your site:</label>
											<input class="col-sm-8" type="text" name="site_name" required="true" style="border: 1px solid #ccc;line-height: 25px;">
										</div>
										<div class="row form-group category-form">
											<label class="col-sm-3">Website URL:</label>
											<input class="col-sm-5" type="text" name="website_url">.{{$site_url}}
										</div>
										<!--<div class="row form-group category-form">
											<label class="col-sm-3">Who can view this site:</label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in required"> 
												<label>Only people you choose (Sign-in required)</label>
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="radio" name="whocanviewsite" value="sign in not required"> 
												<label>Anyone with the website URL (Sign-in not required)</label>
											</div>
										</div>-->
										<div class="row">
											<label class="col-sm-3"></label>
											<div class="col-sm-8">
												<input type="submit" name="submit" value="Continue" class="btn btn-primary"> 
												<!--<a href="" class="btn-create-site">Continue</a>-->
											</div>
										</div>
									</div>
									</form>
									@endif 
									@endforeach
									
								<!--</form>-->
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					@foreach($ssc as $k => $v)
						<div class="category-right-box" id="right_box{{$v->id}}" style="display:@if($v->id == $id)block @else none @endif">
						<h6>{{$v->description}}</h6>
						<?php $string = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $v->features); ?>
						<p>{{$string}}</p>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
<script>
$(function(){
	$('input[name=site_category]').click(function(){
		var val = $(this).val();
		$('.form-category').each(function(){
			$(this).css('display','none');
		});
		$('#form_category'+val).css('display','block');
		$('.category-right-box').each(function(){
			$(this).css('display','none');
		});
		$('#right_box'+val).css('display','block');
	});
	$('#datepicker').datepicker({
		dateFormat:'yy-mm-dd'
	});
	$('#datepicker2').datepicker({
		dateFormat:'yy-mm-dd'
	});
	$('#datepicker3').datepicker({
		dateFormat:'yy-mm-dd'
	});
	
	$('#family input[name=site_name]').on('keyup',function(){
		$('#family input[name=website_url]').val($(this).val());
	});
	$('#sports_team input[name=team_name]').on('keyup',function(){
		$('#sports_team input[name=website_url]').val($(this).val());
	});
	$('#classroom input[name=site_name]').on('keyup',function(){
		$('#classroom input[name=website_url]').val($(this).val());
	});
	$('#event input[name=site_name]').on('keyup',function(){
		$('#event input[name=website_url]').val($(this).val());
	});
	$('#baby input[name=site_name]').on('keyup',function(){
		$('#baby input[name=website_url]').val($(this).val());
	});
	$('#wedding input[name=site_name]').on('keyup',function(){
		$('#wedding input[name=website_url]').val($(this).val());
	});
	$('#travel input[name=site_name]').on('keyup',function(){
		$('#travel input[name=website_url]').val($(this).val());
	});
	$('#photogallery input[name=site_name]').on('keyup',function(){
		$('#photogallery input[name=website_url]').val($(this).val());
	});
	$('#sports_leagues input[name=site_name]').on('keyup',function(){
		$('#sports_leagues input[name=website_url]').val($(this).val());
	});
	$('#club input[name=site_name]').on('keyup',function(){
		$('#club input[name=website_url]').val($(this).val());
	});
});
</script>
@endsection