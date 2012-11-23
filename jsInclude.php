<script>
	window.fbAsyncInit = function() {
		// init the FB JS SDK
		FB.init({
			appId      : '<?= $this->getAppId() ?>',
			channelUrl : '<?= base_url("channel.php?lang=".$this->myApiConfig['language_code']) ?>', // Channel File for x-domain communication
			status     : true,
			cookie     : true,
			xfbml      : true
		});
		
		FB.Canvas.scrollTo(0,0);
		FB.Canvas.setSize({ width: 810, height: $(document.body).offsetHeight });
		window.setInterval(function(){
			FB.Canvas.setSize({ width: 810, height: $(document.body).offsetHeight });
		},500);
	};

	(function(d, debug){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/<?= $this->myApiConfig['language_code'] ?>/all" + (debug ? "/debug" : "") + ".js";
		ref.parentNode.insertBefore(js, ref);
	}(document, /*debug*/ <?= var_export($this->myApiConfig['debug']) ?>))
</script>
<div id="fb-root"></div>
