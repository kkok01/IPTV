<?php
  /*
  食用方法litv.php?id=4gtv-4gtv001
  
民视台湾台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv001
民视,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv002
民视第一台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv003
民视综艺,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv004
猪哥亮歌厅秀,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv006
八大精彩台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv034
八大综艺台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv039
中视,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv040
华视,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv041
公视戏剧,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv042
台视新闻,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv051
华视新闻,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv052
台视,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv066
tvbs新闻台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv072
tvbs,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv073
中视新闻,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv074
中视经典,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv080
民视,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv155
民视台湾台,http://kkok01.serv00.net/litv.php?id=4gtv-4gtv156
民视影剧,http://kkok01.serv00.net/litv.php?id=litv-ftv09
民视新闻台,http://kkok01.serv00.net/litv.php?id=litv-ftv13
台湾戏剧台,http://kkok01.serv00.net/litv.php?id=litv-longturn22
  
  一般来说没声音调节第二个参数就行，从1-10.
  */
  header('Content-Type: text/plain; charset=utf-8');
  $id = isset($_GET['id'])?$_GET['id']:'4gtv-4gtv006';
  $n=array(
    '4gtv-4gtv001' => [1, 6],//民视台湾台
    '4gtv-4gtv002' => [1, 10],//民视
    '4gtv-4gtv003' => [1, 6],//民视第一台
    '4gtv-4gtv004' => [1, 8],//民视综艺
    '4gtv-4gtv006' => [1, 9],//猪哥亮歌厅秀
    '4gtv-4gtv034' => [1, 6],//八大精彩台
    '4gtv-4gtv039' => [1, 7],//八大综艺台
    '4gtv-4gtv040' => [1, 6],//中视
    '4gtv-4gtv041' => [1, 6],//华视
    '4gtv-4gtv042' => [1, 6],//公视戏剧
    '4gtv-4gtv051' => [1, 6],//台视新闻
    '4gtv-4gtv052' => [1, 8],//华视新闻
    '4gtv-4gtv066' => [1, 2],//台视
    '4gtv-4gtv072' => [1, 2],//tvbs新闻台
    '4gtv-4gtv073' => [1, 8],//tvbs
    '4gtv-4gtv074' => [1, 8],//中视新闻
    '4gtv-4gtv080' => [1, 2],//中视经典
    '4gtv-4gtv155' => [1, 6],//民视
    '4gtv-4gtv156' => [1, 2],//民视台湾台
    'litv-ftv07' => [1, 7],//民视旅游
    'litv-ftv09' => [1, 7],//民视影剧
    'litv-ftv13' => [1, 7],//民视新闻台
    'litv-longturn22' => [5, 2],//台湾戏剧台
    );
  $timestamp = intval(time()/4-355017625);
  $t=$timestamp*4;
  $current = "#EXTM3U"."\r\n";
  $current.= "#EXT-X-VERSION:3"."\r\n";
  $current.= "#EXT-X-TARGETDURATION:4"."\r\n";
  $current.= "#EXT-X-MEDIA-SEQUENCE:{$timestamp}"."\r\n";
  for ($i=0; $i<3; $i++) {
        $current.= "#EXTINF:4,"."\r\n";
    $current.="https://litvpc-hichannel.cdn.hinet.net/live/pool/{$id}/litv-pc/{$id}-avc1_6000000={$n[$id][0]}-mp4a_134000_zho={$n[$id][1]}-begin={$t}0000000-dur=40000000-seq={$timestamp}.ts"."\r\n";
        $timestamp = $timestamp+1;
    $t=$t+4;
        }
  header('Content-Type: application/vnd.apple.mpegurl'); 
  header('Content-Disposition: inline; filename='.$id.'.m3u8');
  header('Content-Length: ' . strlen($current)); 
     echo $current;
