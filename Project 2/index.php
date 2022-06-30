<!-- Starting Configs -->
<?php
require_once('./COMPONENTS/GLOBAL.php');
$API = './demo.json';
$videos = json_decode(file_get_contents($API), true) or die("<center><h1>Cannot Fetch Images</h1></center>");
if (!isset($_GET['video_id'])) {
    $main_video = $videos['data'][0];
    unset($videos['data'][0]);
    $nextVideoUrl = "./?video_id={$videos['data'][1]['contentId']}";
} else {
    $main_video = null;
    for ($i = 0; $i < count($videos['data']); $i++) {
        if ($videos['data'][$i]['contentId'] == $_GET['video_id']) {
            $main_video = $videos['data'][$i];
            if (isset($videos['data'][$i + 1])) {
                $nextVideoUrl = "./?video_id={$videos['data'][$i + 1]['contentId']}";
            } else {
                $nextVideoUrl = "./?video_id={$videos['data'][0]['contentId']}";
            }
            unset($videos['data'][$i]);
        }
    }
    $main_video == null ? header("Location: ./") : null;
}
$videos['data'] = array_values($videos['data']);
?>
<?php require_once('./COMPONENTS/header.php'); ?>
<!-- Starting -->
<div class="container-fluid my-md-4 py-md-4 px-md-5">
    <div class="row px-md-5">
        <div class="col-md-8">
            <div class="video-card video-mega-card currentVideo" data-next-url="<?php echo $nextVideoUrl; ?>">
                <div class="video-player" data-height="<?php echo $main_video['assets'][3]['height']; ?>" data-poster-url="<?php echo $main_video['thumbnails'][2]['url']; ?>" data-video-url="<?php echo $main_video['assets'][3]['url']; ?>"></div>
                <div class="video-data mt-4">
                    <h2><?php echo $main_video['metadata']['title']; ?></h2>
                    <p class="mt-4">
                        <?php echo $main_video['metadata']['description']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="playlist">
                <?php
                for ($i = 0; $i < count($videos['data']); $i++) {
                    $video = $videos['data'][$i];
                    $video_md_thumb = $video['thumbnails'][0]['url'];
                ?>
                    <a class="mt-3 d-block" href="./?video_id=<?php echo $video['contentId'] ?>">
                        <div class="video-card video-card d-flex flex-wrap justify-content-center">
                            <div class="col-md-6 pl-md-0">
                                <div class="video-thumb" style="background-image: url('<?php echo $video_md_thumb; ?>');">
                                    <div class="aks-vp-start">
                                        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 240 240" focusable="false">
                                            <path d="M62.8,199.5c-1,0.8-2.4,0.6-3.3-0.4c-0.4-0.5-0.6-1.1-0.5-1.8V42.6c-0.2-1.3,0.7-2.4,1.9-2.6c0.7-0.1,1.3,0.1,1.9,0.4l154.7,77.7c2.1,1.1,2.1,2.8,0,3.8L62.8,199.5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="duration badge badge-secondary d-table float-right"><?php echo formatSeconds($video['metadata']['duration']); ?></div>
                            </div>
                            <div class="video-data col-md-6">
                                <p class="text-dark"><?php echo $video['metadata']['title']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <button class="btn btn-block btn-info mt-4 loadMoreBtn" onclick="loadMore();">Load More</button>
        </div>
    </div>
</div>
<!-- Ending -->
<?php require_once('./COMPONENTS/footer.php'); ?>