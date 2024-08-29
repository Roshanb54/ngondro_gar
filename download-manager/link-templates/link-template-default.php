<?php 
    $_files = get_post_meta(get_the_ID(), '__wpdm_files', true);
    if($_files){
    $filepath =  WPDM()->fileSystem->absPath(array_shift($_files),get_the_ID());
    }
    $get_package_data = (array) get_package_data(get_the_ID(), 'files');
    $package_size = get_package_data(get_the_ID(), 'package_size');
    $size_int = (int) filter_var($package_size, FILTER_SANITIZE_NUMBER_INT);
    if($filepath){
    $ext = pathinfo(
        parse_url($filepath, PHP_URL_PATH), 
        PATHINFO_EXTENSION
    ); //$ext will be gif
    }
    $supported_audio = array('mp3');
    $supported_video = array('mp4');
    $supported_image = array(
        'jpg',
        'svg',
        'jpeg',
        'png'
    );
    $array_count = count($get_package_data);
    $url_parsed_arr = parse_url($filepath);
if($array_count === 1 && in_array($ext, $supported_image)){
$split_url = explode("/wp-content/",  $filepath);
if($split_url[1]){
    $file_url = site_url('/wp-content/').''.$split_url[1];
}else {
    $file_url = '[download_url]';
}
// if($size_int !== 0 ): ?>
<!-- <span class="wpdm-file-size">
    <i class="fas fa-hdd ml-3"></i> 
    [file_size]</span> -->
<?php //endif;
?>
<div class="custom-resource-item-wrapper link-template-default card mb-2">
    <div class="card-body">
        <div class="media">
<div class="resource-file-details">
            <div class="mr-3 img-48">[icon]</div>
            <div class="media-body">
                <h4 class="package-title"><a data-fancybox href="<?php echo $file_url;?>">[title]</a></h4><div class="resource-description">[description]</div>
                <div class="text-muted text-small"><i class="fas fa-copy"></i> [file_count] [txt=file(s)]</div>
            </div>
</div>
            <div class="resource-download-btn ml-3">
                <a class="wpdm-download-link btn btn-primary" data-fancybox rel="nofollow" href="<?php echo $file_url;?>">Preview <i class="fas fa-eye"></i></a>
            </div>
        </div>
    </div>
</div>
<?php } elseif($array_count === 1 && in_array($ext, $supported_audio)){ ?>
    <div class="custom-resource-item-wrapper link-template-default card mb-2">
    <div class="card-body">
        <div class="media">
<div class="resource-file-details">
            <div class="mr-3 img-48">[play_button]</div>
            <div class="media-body">
                <h4 class="package-title">[title]</h4><div class="resource-description">[description]</div>
                <div class="text-muted text-small"><i class="fas fa-copy"></i> [file_count] [txt=file(s)]</div>
            </div>
</div>
            <div class="resource-download-btn ml-3">
                <a class="wpdm-download-link download-on-click btn btn-primary" rel="nofollow" href="[download_url]" data-downloadurl="[download_url]" target="_blank">Play <i class="fas fa-play"></i></a>
            </div>
        </div>
    </div>
</div>

<?php }elseif($array_count === 1 && in_array($ext, $supported_video)){
    $split_url = explode("/wp-content/",  $filepath);
    if($split_url[1]){
        $video_file_url = site_url('/wp-content/').''.$split_url[1];
    }else {
        $video_file_url = '[download_url]';
    }
    ?>
    <div class="custom-resource-item-wrapper link-template-default card mb-2">
    <div class="card-body">
        <div class="media">
            <div class="resource-file-details">
            <div class="mr-3 img-48">[icon]</div>
            <div class="media-body">
                <h4 class="package-title"><a data-fancybox data-type="iframe" href="<?php echo $video_file_url;?>" target="_blank">[title]</a></h4><div class="resource-description">[description]</div>
                <div class="text-muted text-small"><i class="fas fa-copy"></i> [file_count] [txt=file(s)] </div>
            </div>
        </div>
            <div class="resource-download-btn ml-3">
                <a class="wpdm-download-link download-on-click btn btn-primary" data-fancybox  data-type="iframe" rel="nofollow" href="<?php echo $video_file_url;?>" target="_blank">Download</a>
            </div>
        </div>
    </div>
</div>

<?php } elseif ($array_count === 1 && (($url_parsed_arr['host'] == "www.youtube.com" && $url_parsed_arr['path'] == "/watch" && substr($url_parsed_arr['query'], 0, 2) == "v=" && substr($url_parsed_arr['query'], 2) != "")|| $url_parsed_arr['host'] == "vimeo.com")) { ?>
    <div class="custom-resource-item-wrapper link-template-default card mb-2">
    <div class="card-body">
        <div class="media">
            <div class="resource-file-details">
            <div class="mr-3 img-48">[icon]</div>
            <div class="media-body">
                <h4 class="package-title"><a data-fancybox data-type="iframe" href="<?php echo $filepath;?>" target="_blank">[title]</a></h4><div class="resource-description">[description]</div>
                <div class="text-muted text-small"><i class="fas fa-copy"></i> [file_count] [txt=file(s)]</div>
            </div>
        </div>
            <div class="resource-download-btn ml-3">
                <a class="wpdm-download-link download-on-click btn btn-primary" data-fancybox  data-type="iframe" rel="nofollow" href="<?php echo $filepath;?>" target="_blank">Watch <i class="fas fa-eye"></i></a>
            </div>
        </div>
    </div>
</div>  
   <?php } else { ?>
    <div class="custom-resource-item-wrapper link-template-default card mb-2">
    <div class="card-body">
        <div class="media">
            <div class="resource-file-details">
            <div class="mr-3 img-48">[icon]</div>
            <div class="media-body">
                <h4 class="package-title"><a href="[download_url]" data-downloadurl="[download_url]" target="_blank">[title]</a></h4><div class="resource-description">[description]</div>
                <div class="text-muted text-small"><i class="fas fa-copy"></i> [file_count] [txt=file(s)] </div>
            </div>
        </div>
            <div class="resource-download-btn ml-3">
                <a class="wpdm-download-link download-on-click btn btn-primary" rel="nofollow" href="[download_url]" data-downloadurl="[download_url]" target="_blank">Download</a>
            </div>
        </div>
    </div>
</div>

<?php }


