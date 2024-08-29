<!DOCTYPE html>
<html>
<head>
<title><?php echo __('Access Denied', 'ngondro_gar');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta charset="UTF-8">
<style>
h1 {
    color: #000;
}

h6{
    color: #000;
    text-decoration: italic;
}

.change_pass{
    padding:10% 10%;
    text-align:center;
}

</style>
</head>
    <body>
        <div class="w3-display-middle change_pass">
            <h1 class="w3-jumbo w3-animate-top w3-center"><code><?php echo __('Access Denied', 'ngondro_gar');?></code></h1>
            <hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
            <h3 class="w3-center w3-animate-right"><?php echo __('You dont have permission to view this site.', 'ngondro_gar');?></h3>
            <h3 class="w3-center w3-animate-zoom">🚫🚫🚫🚫</h3>
            <h6 class="w3-center w3-animate-zoom"><?php echo __('Click here to ', 'ngondro_gar');?><a href="<?=site_url()?>"><?php echo __('Home', 'ngondro_gar');?></a></h6>
        </div>
    </body>
</html>