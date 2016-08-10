var imagesAreAligned = false;
(function($) {
	
	$(document).ready(function(){
		var isAjax = false;
		var totalImagesToBeLoaded = 5;
		new Preloader.Instance();
		
		/* Sidebar Trigger Handler */
		$("#sidebar-trigger").click(function(e){
			e.preventDefault();
			var body = $('body');
			if (body.hasClass('display-sidebar'))
			{
				body.removeClass('display-sidebar');
			}
			else
			{
				body.addClass('display-sidebar');
			}
		});
		
		$("#sidebar").each(function(){
			var sidebar = $(this);
			sidebar.find(".sidebar-content").css('min-height', $(window).height() - 200 - sidebar.position().top);
		});
		
		/* End Sidebar Trigger Handler */
		
		/* Handle Slider */
		var slider = $("#slider");
		var isSliding = false;
		var sliderHolder = slider.children('ul');
		var sliderSlides = sliderHolder.children('li');
		var sliderImages = sliderSlides.children('img');
		slider.height($(window).height());
		sliderSlides.eq(0).addClass('active');
		
		$(window).load(function(){
			AlignSliderImages(slider, sliderImages);
			SliderInit();
		}).resize(function(){
			slider.height($(window).height());
			AlignSliderImages(slider, sliderImages);
		}).mousemove(function(e){
			if (imagesAreAligned)
			{
				var r = (e.clientY * 100 / $(window).height());
				sliderHolder.css({ 
					'top': (25 * (100-r) / 100),
					'bottom': (25 * r / 100)
				});
			}
		});
		
		slider.children('.slider-prev').click(function(e){
			e.preventDefault();
			
			if (!isSliding)
			{
				clearInterval(window.sliderIntervalId);
				
				var currentSlide = sliderHolder.children('.active');
				var currentSlideIndex = currentSlide.index();
				var nextSlide = sliderSlides.eq(--currentSlideIndex < 0 ? (sliderSlides.length-1) : currentSlideIndex);
				
				Slide(currentSlide, nextSlide);			
				SliderInit();
			}
		});
		
		slider.children('.slider-next').click(function(e){
			e.preventDefault();
			
			if (!isSliding)
			{
				clearInterval(window.sliderIntervalId);
				
				var currentSlide = sliderHolder.children('.active');
				var currentSlideIndex = currentSlide.index();
				var nextSlide = sliderSlides.eq(++currentSlideIndex >= sliderSlides.length ? 0 : currentSlideIndex);
				
				Slide(currentSlide, nextSlide);
				SliderInit();
			}
		});
		
		slider.children(".slider-back").click(function(e){
			e.preventDefault();
			
			history.go(-1);
		});
		
		var queuedImagesToBeLoaded = 0;
		slider.find("img").each(function(){
			if (queuedImagesToBeLoaded++ < totalImagesToBeLoaded)
			{
				Preloader.Instance.AddImageInQueue($(this).attr('src'));
			}
		});
		
		Preloader.Instance.LoadImages();
		
		function AlignSliderImages(slider, images)
		{
			var sliderWidth = slider.width();
			var sliderHeight = slider.height()+80;
			var sliderRate = sliderWidth / sliderHeight;
			var currentImage = images.eq(0);
			var rate = currentImage.width() / currentImage.height();

			if (rate > sliderRate)
			{
				var width = sliderHeight * rate;
				images.css({
					'width': width,
					'height': sliderHeight,
					'margin-top': -40,
					'margin-left': (sliderWidth - width) / 2
				});
			}
			else
			{
				var height = sliderWidth / rate
				images.css({				
					'width': sliderWidth,
					'height': height,
					'margin-top': (sliderHeight - height - 20) / 2,
					'margin-left': 0
				});
			}
			
			imagesAreAligned = true;
			slider.children('ul').removeClass('before-init');
		}
		
		function SliderInit()
		{
			window.sliderIntervalId = setInterval(function(){
				var currentSlide = sliderHolder.children('.active');
				var currentSlideIndex = currentSlide.index();
				var nextSlide = sliderSlides.eq(++currentSlideIndex >= sliderSlides.length ? 0 : currentSlideIndex);
				Slide(currentSlide, nextSlide);
			}, 5000);	
		}
		
		function Slide(currentSlide, nextSlide)
		{
			isSliding = true;
			currentSlide.animate({ 'opacity': 0 }, 800, function(){
				currentSlide.removeClass('active');
			});
			nextSlide.animate({ 'opacity': 1 }, 800, function(){
				nextSlide.addClass('active');
				isSliding = false;
			});
		}
		/* End Handle Slider */
		
		/* Handle Side Posts */
		$("#blog-listing").each(function(){
			var side = $(this).find(".site-side");
			
			side.each(function(){
				var main = side.siblings(".site-main");
				var articles = side.children(".post");
				
				while (side.height() > main.height() && articles.length > 0)
				{
					articles.eq(articles.length-1).remove();
					articles = side.children(".post");
				}
			});
		});
		/* End Handle Side Posts */
		
		/* Handle Comments Form */
		$("#commentform").each(function(){
			var form = $(this);
			form.find("label").each(function(){
				var label = $(this);
				var field = $(this).parent().find('input[type=text], textarea');
				
				label.click(function(){
					field.focus();
				});
				field.focus(function(){
					label.hide();
				}).blur(function(){
					if ($.trim($(this).val()) == "")
					{
						label.show();
					}
				});
				
				if ($.trim(field.val()) != "")
				{
					label.hide();
				}
			});
			
			form.submit(function(e){
				e.preventDefault();
				
				if (!isAjax)
				{
					isAjax = true;
					var explanation = form.parent().siblings("#explanation").children(".inside");
					explanation.empty();
					
					$.ajax({
						"url": form.attr("action"),
						"type": "POST",
						"data": form.serialize(),
						"error": function(response) {
							var responseText = response.responseText;
							var error = "There was an error!";
							var start = responseText.indexOf('<body id="error-page">');
							var end = responseText.indexOf("</body>");
							if (start != -1 && end != -1)
							{
								error = responseText.substring(start + 22, end);
								explanation.html(error);
							}
							isAjax = false;
						},
						"success": function(){
							window.location.reload();
						}
					});
				}
			});
		
		});
		/* End Handle Comments Form */
	});
	
	;(function(window) 
	{
		window.Preloader = Preloader = new Object();	
		Preloader.Instance = function()
		{
			var self;
			var isAjax = false;
			var loaded = 0;
			var preloader, preloaderProgress;
			var queue = new Array();
			var images = new Array();
			
			var AddImageInQueue = Preloader.Instance.AddImageInQueue = function(imageSrc)
			{
				images.push(imageSrc);
			};
			
			var LoadImages = Preloader.Instance.LoadImages = function()
			{
				for (var i in images)
				{
					var image = new Image(1,1);
					image.src = images[i];
					queue.push(image);
				}
				
				for (var i in queue)
				{
					queue[i].onload = function()
					{
						var width = ++loaded / queue.length;
						preloaderProgress.width(width * preloader.width());
						if (width == 1)
						{
							setTimeout('Preloader.Instance.HidePreloader()', 1000);
						}
					}
				}
			};
			
			var LoadImages = Preloader.Instance.SimpleLoadImages = function()
			{
				for (var i in images)
				{
					var image = new Image(1,1);
					image.src = images[i];
					queue.push(image);
				}
			};
			
			Preloader.Instance.HidePreloader = function()
			{
				$("#slider ul").animate({ 'opacity': 1 }, 500);
				preloader.fadeOut(500, function(){
					preloader.remove();	
				});
			};
			
			var InitializeObjects = function()
			{
				preloader = $("#image-loader");
				preloaderProgress = $("#image-loader-progress");
			};
			
			(this.Init = function()
			{
				self = this;
				
				InitializeObjects();
			})();
		}
	})(window);
	
})( jQuery );
