@php
	$categories = App\Model\Category::where('soft_delete',0)->get();
    $subcategories = App\Model\Subcategory::where('soft_delete',0)->get();
    $seo = App\Model\Seo::first();
    $social = App\Model\Social::first();
    $headlines = App\Model\Post::where('headline',1)->orderBy('id','DESC')->get();
    $notice = App\Model\Notice::first();

    $horizontal1 = DB::table('ads')->first();

    $system = DB::table('settings')->first();
    
@endphp
 @php
    function bn_date($str)
    {
        $en = array(1,2,3,4,5,6,7,8,9,0);
        $bn = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
        $str = str_replace($en, $bn, $str);
        $en = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
        $en_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
        $bn = array( 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );
        $str = str_replace( $en, $bn, $str );
        $str = str_replace( $en_short, $bn, $str );
        $en = array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
        $en_short = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
        $bn_short = array('শনি', 'রবি','সোম','মঙ্গল','বুধ','বৃহঃ','শুক্র');
        $bn = array('শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার');
        $str = str_replace( $en, $bn, $str );
        $str = str_replace( $en_short, $bn_short, $str );
        $en = array( 'am', 'pm' );
        $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন' );
        $str = str_replace( $en, $bn, $str );
        $str = str_replace( $en_short, $bn_short, $str );
        $en = array( '১২', '২৪' );
        $bn = array( '৬', '১২' );
        $str = str_replace( $en, $bn, $str );
         return $str;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="{{ $seo->meta_author_en }}">
        <meta name="keyword" content="{{ $seo->meta_keyword_en }}">
        <meta name="description" content="{{ $seo->meta_description_en }}">
        <meta name="google-verification" content="{{ $seo->google_verifications }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')
     
        <title>NEWSPAPER</title>

        <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/menu.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/style.css') }}" rel="stylesheet">

    </head>
    <body>
    <!-- header-start -->
	<section class="hdr_section">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-xs-6 col-md-2 col-sm-4">
					<div class="header_logo">
						<a href="{{ route('/') }}"><img src="{{ asset($system->logo) }}" style="height: 60px;"></a> 
					</div>
				</div>              
				<div class="col-xs-6 col-md-8 col-sm-8">
					<div id="menu-area" class="menu_area">
						<div class="menu_bottom">
							<nav role="navigation" class="navbar navbar-default mainmenu">
						<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>
								<!-- Collection of nav links and other content for toggling -->
								<div id="navbarCollapse" class="collapse navbar-collapse">
									<ul class="nav navbar-nav">
										@foreach($categories as $category)
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													@if(session()->get('lang') == 'English')
														{{ $category->name_en }}
													@else
														{{ $category->name_bn }}
													@endif
												</a>
												<ul class="dropdown-menu">
													@foreach($subcategories as $subcategory)
														@php
															if (session()->get('lang')=='English') {
																$slug = preg_replace('/\s+/u','-',trim($subcategory->name_en));
															}else{
																$slug = preg_replace('/\s+/u','-',trim($subcategory->name_bn));
															}
														@endphp
														@if($category->id == $subcategory->category_id)
															<li><a href="{{ URL::to('/view-all-post/'.$category->id.'/'.$subcategory->id.'/'.$slug) }}">
																@if(session()->get('lang') == 'English')
																	{{ $subcategory->name_en }}
																@else
																	{{ $subcategory->name_bn }}
																@endif
															</a></li>
														@endif
													@endforeach
													
												</ul>
											</li>
										@endforeach
									</ul>
								</div>
							</nav>											
						</div>
					</div>					
				</div> 
				<div class="col-xs-12 col-md-2 col-sm-12">
					<div class="header-icon">
						<ul>
							<!-- version-start -->
							
							    
							    @if(session()->get('lang') == "English")
									<li class="version"><a href="{{ route('bangla') }}">বাংলা</a></li>
							    @else
									<li class="version"><a href="{{ route('english') }}">Englsih</a></li>
							    @endif
							

							<!-- login-start -->
						
							<!-- search-start -->
							<li><div class="search-large-divice">
								<div class="search-icon-holder"> <a href="#" class="search-icon" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-search" aria-hidden="true"></i></a>
									<div class="modal fade bd-example-modal-lg" action="" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <i class="fa fa-times-circle" aria-hidden="true"></i> </button>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-12">
															<div class="custom-search-input">
																<form>
																	<div class="input-group">
																		<input class="search form-control input-lg" placeholder="search" value="Type Here.." type="text">
																		<span class="input-group-btn">
																		<button class="btn btn-lg" type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
																	</span> </div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></li>
							<!-- social-start -->
							<li>
								<div class="dropdown">
								  <button class="dropbtn-02"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
								  <div class="dropdown-content">
									<a href="{{ $social->facebook }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
									<a href="{{ $social->tweter }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a>
									<a href="{{ $social->youtube }}" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i> Youtube</a>
									<a href="{{ $social->instagram }}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a>
								  </div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section><!-- /.header-close -->
	
    <!-- top-add-start -->
	<section>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
					<div class="top-add">
						@if($horizontal1)
							<a href="{{ $horizontal1->link}}"><img src="{{asset($horizontal1->ads)}}" alt=""/></a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section> <!-- /.top-add-close -->
	
	<!-- date-start -->
    <section>
    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-md-12 col-sm-12">
					<div class="date">
						<ul>
							<script type="text/javascript" src="http://bangladate.appspot.com/index2.php"></script>
							<li>
								<i class="fa fa-map-marker" aria-hidden="true"></i>
								@if(session()->get('lang')== 'English')
									Dhaka 
								@else
									ঢাকা 
								@endif
							</li>
							<li>
								<i class="fa fa-calendar" aria-hidden="true"></i>
								@if(session()->get('lang')== 'English')
									{{date('d F Y, l, h:i:s a')}}  
								@else
									{{ bn_date(date('d F Y, l, h:i:s a'))}}  
								@endif
							
							</li>
							<li>
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								@if(session()->get('lang')== 'English')
									Updated 5 minutes ago
								@else
									আপডেট ৫ মিনিট আগে
								@endif 
							</li>
						</ul>
						
					</div>
				</div>
    		</div>
    	</div>
    </section><!-- /.date-close -->  

	
	 
    <section>
    	<div class="container-fluid">
			<div class="row scroll">
				<div class="col-md-2 col-sm-3 scroll_01 ">
					@if(session()->get('lang')== 'English')
						Headline :
					@else
						শিরোনাম :
					@endif 
					
				</div>
				<div class="col-md-10 col-sm-9 scroll_02">
					<marquee>
						@foreach($headlines as $headline)
							<a href="#" style="color: white;text-decoration: none;">
								@if(session()->get('lang')== 'English')
									* {{ $headline->title_en }} 
								@else
									* {{ $headline->title_bn }} 
								@endif 
							</a>
						@endforeach
					</marquee>
				</div>
			</div>
    	</div>
    </section>

    @if($notice->status == 1)
		    <section>
		    	<div class="container-fluid">
					<div class="row scroll">
						<div class="col-md-2 col-sm-3 scroll_01" style="background-color: green;">
							@if(session()->get('lang')== 'English')
								Notice :
							@else
								নোটিশ :
							@endif 
							
						</div>
						<div class="col-md-10 col-sm-9 scroll_02">
							<marquee>
								<a href="#" style="color: white;text-decoration: none;">
									@if(session()->get('lang')== 'English')
								   		* {{ $notice->notice_en }} *
									@else
										* {{ $notice->notice_bn }} *
									@endif 
								</a>
							</marquee>
						</div>
					</div>
		    	</div>
		    </section> 
    @endif   


    @yield('content')
	
	<!-- top-footer-start -->
	<section>
		<div class="container-fluid">
			<div class="top-footer">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="foot-logo">
							<img src="{{asset($system->logo)}}" style="height: 50px;" />
						</div>
					</div>
					<div class="col-md-6 col-sm-4">
						 <div class="social">
                            <ul>
                                <li><a href="{{ $social->facebook }}" target="_blank" class="facebook"> <i class="fa fa-facebook"></i></a></li>
                                <li><a href="{{ $social->tweter }}" target="_blank" class="twitter"> <i class="fa fa-twitter"></i></a></li>
                                <li><a href="{{ $social->instagram }}" target="_blank" class="instagram"> <i class="fa fa-instagram"></i></a></li>
                               {{--  <li><a href="{{ $social->facebook }}" target="_blank" class="android"> <i class="fa fa-android"></i></a></li> --}}
                                {{-- <li><a href="{{ $social->linkedin }}" target="_blank" class="linkedin"> <i class="fa fa-linkedin"></i></a></li> --}}
                                <li><a href="{{ $social->youtube }}" target="_blank" class="youtube"> <i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
					</div>
					<div class="col-md-3 col-sm-4">
						<div class="apps-img">
							<ul>
								<li><a href="#"><img src="{{asset('frontend/assets/img/apps-01.png')}}" alt="" /></a></li>
								<li><a href="#"><img src="{{asset('frontend/assets/img/apps-02.png')}}" alt="" /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- /.top-footer-close -->
	
	<!-- middle-footer-start -->	
	<section class="middle-footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<div class="editor-one">
						@if(session()->get('lang')== 'English')
					   		 {{ $system->address_en }} 
						@else
							 {{ $system->address_bn }} 
						@endif 
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="editor-two">
						<img src="{{asset($system->logo)}}" style="height: 50px;" />
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="editor-three">
						@if(session()->get('lang')== 'English')
					   		 {{ $system->phone_en }} 
						@else
							 {{ $system->phone_bn }} 
						@endif 
					</div>
				</div>
			</div>
		</div>
	</section><!-- /.middle-footer-close -->
	
	<!-- bottom-footer-start -->	
	<section class="bottom-footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="copyright">						
						All rights reserved © 2020 <a href="https://the-ashikur.com/">the-ashikur.com</a>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="btm-foot-menu">
						{{-- <ul>
							<li><a href="#">About US</a></li>
							<li><a href="#">Contact US</a></li>
						</ul> --}}
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	
	
	
	
		<script src="{{ asset('frontend/assets/js/jquery.min.js')}}"></script>
		<script src="{{ asset('frontend/assets/js/bootstrap.min.js')}}"></script>
		<script src="{{ asset('frontend/assets/js/main.js')}}"></script>
		<script src="{{ asset('frontend/assets/js/owl.carousel.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('select[name="division_id"]').on('change',function(){
      var division_id = $(this).val();
      if (division_id) {
        $.ajax({
          url:"{{ url('/get/district/') }}/"+division_id,
          type:"GET",
          dataType:"json",
          success:function(data){
            $("#district_id").empty();  
            $("#district_id").append('<option selected="selected" disabled="">==Chose One==</option>');
            $.each(data,function(key,value){
              $("#district_id").append('<option value="'+value.id+'"">'+value.name_en+' | '+value.name_bn+'</option>');
            });
            //console.log(data)
          }
        });
      }
    });
  });
</script>
	</body>
</html> 