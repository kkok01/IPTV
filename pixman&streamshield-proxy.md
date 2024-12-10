VPS-out

一、Pixman

docker run -d --name=pixman -p 5000:5000 \
--restart always \
pixman/pixman

获取M3U列表
- 四季線上 4GTV (`http://ip:5000/4gtv.m3u`)
- 江苏移动魔百盒 TPTV (`http://ip:5000/tptv.m3u` 或 `http://ip:5000/tptv_proxy.m3u`)
- 央视频直播源 (`http://ip:5000/ysp.m3u`)
- LITV 直播源 (合并到 4gtv)
- YouTube 直播源 (`http://ip:5000/youtube/{VIDEO_ID}`)
- MytvSuper 直播源 (`http://ip:5000/mytvsuper.m3u`)
- Beesport 直播源 (`http://ip:5000/beesport.m3u`)
- 中国移动 iTV 平台 (`http://ip:5000/itv.m3u` 或 `http://ip:5000/itv_proxy.m3u`)
- TheTV (`http://ip:5000/thetv.m3u`)
- Hami Video (`http://ip:5000/hami.m3u`)
- DLHD (`http://ip:5000/dlhd.m3u`)

二、结合 streamshield-proxy 免梯

docker run -d -p 5001:4994 --name tvproxy \
-e CUSTOM_DOMAIN="http://ip:5000" \
-e VPS_HOST="http://ip:5001" \
-e SECURITY_TOKEN="IPTV" \
-e INCLUDE_MYTVSUPER="true" \
-e CHINAM3U="true" \
--restart always \
ppyycc/streamshield-proxy:latest

PS：
MYTVSUPER 是否启用
CHINAM3U 是否启用

获取M3U列表
http://ip:5001/IPTV
