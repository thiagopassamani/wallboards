$(document).ready(function()
{
	var pepe = $.fn.fullpage(
	{
		anchors: ['dash-1', 'dash-2', 'dash-3', 'dash-4', 'lastPage'],
		scrollingSpeed: 700,
		easing: 'easeInQuart',
		resize : true,
		autoScrolling: true,
		keyboardScrolling: true,
		loopBottom: true,
		onLeave: function(index, direction){},
		afterLoad: function(anchorLink, index){},
		afterRender: function()
		{
			setInterval(function()
			{
				$.fn.fullpage.moveSectionDown();
   }, 15000); /* Slide move */
  },
  afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},
  onSlideLeave: function(anchorLink, index, slideIndex, direction){},
 });
});