(function($) {
	'use strict';
  
	// Function được chạy khi DOM đã sẵn sàng
	$(function(e) {
  
	  // Trending Slider - Cấu hình slider cho trending (xu hướng)
	  var owl = $("#trending_slider");
	  owl.owlCarousel({
		itemsCustom: [
		  [0, 1],
		  [450, 1],
		  [550, 1],
		  [700, 3],
		],
		loop: true,     
		nav: true,      
		navigation: false, 
		autoPlay: 3000  
	  });
  
	  // Popular Brands Slider - Cấu hình slider cho thương hiệu phổ biến
	  var owl = $("#popular_brands");
	  owl.owlCarousel({
		itemsCustom: [
		  [0, 2],
		  [450, 2],
		  [550, 2],
		  [700, 3],
		  [1024, 4],
		  [1200, 5],
		],
		loop: true,     
		nav: true,      
		navigation: false, 
		autoPlay: 3000  
	  });
  
	  // Listing Image Slider - Cấu hình slider cho hình ảnh sản phẩm
	  var owl = $("#listing_img_slider");
	  owl.owlCarousel({
		itemsCustom: [
		  [0, 1],
		  [450, 1],
		  [700, 2],
		  [1024, 3],
		  [1200, 3],
		],
		loop: true,     
		nav: true,      // Hiển thị điều hướng
		navigation: true,  // Sử dụng navigation cho slider này
		pagination: false, // Tắt pagination (chấm tròn nhỏ để chuyển trang)
		autoPlay: 3000  
	  });
  
	  // Listing Images Slider - Sử dụng Slick slider cho hình ảnh sản phẩm
	  $('.listing_images_slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,    // Tắt mũi tên điều hướng
		fade: true,       // Hiệu ứng mờ khi chuyển slide
		asNavFor: '.listing_images_slider_nav' // Kết hợp với slider navigation
	  });
  
	  // Navigation cho slider images
	  $('.listing_images_slider_nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.listing_images_slider', // Kết hợp với slider chính
		dots: false,        // Tắt dot pagination
		centerMode: true,   // Chế độ hiển thị ảnh giữa nổi bật hơn
		focusOnSelect: true // Cho phép chọn slide khi nhấn vào ảnh
	  });
  
	  // Price range slider
	  $("#price_range").slider({});
  
	  // Toggle search form - Ẩn hiện form tìm kiếm khi nhấn vào nút
	  $("#search_toggle").click(function() {
		$("#header-search-form").slideToggle();
	  });
  
	  // Toggle filter form - Ẩn hiện form lọc khi nhấn vào nút
	  $("#filter_toggle").click(function() {
		$("#filter_form").slideToggle();
	  });
  
	  // Toggle other info - Ẩn hiện thông tin thêm khi nhấn vào nút
	  $("#other_info").click(function() {
		$("#info_toggle").slideToggle();
	  });
  
	  // Back-to-top button logic
	  var top = $('#back-top');
	  top.hide();  // Ẩn nút back-to-top ban đầu
	  
	  // Hiển thị nút back-to-top khi người dùng cuộn xuống hơn 100px
	  $(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
		  top.fadeIn();  // Hiện nút
		} else {
		  top.fadeOut(); // Ẩn nút
		}
	  });
  
	  // Cuộn trang về đầu khi nhấn vào nút back-to-top
	  $('#back-top a').on('click', function(e) {
		e.preventDefault();  // Ngăn chặn hành vi mặc định của liên kết
		$('body,html').animate({
		  scrollTop: 0
		}, 800);  // Cuộn về đầu trang trong 800ms
		return false;
	  });
	});
  })(jQuery);
  