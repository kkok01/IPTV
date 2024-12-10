allinone
docker run -d --restart unless-stopped --privileged=true -p 6002:35455 --name allinone youshandefeiyang/allinone
监测
docker run -d --name watchiptv --restart unless-stopped -v /var/run/docker.sock:/var/run/docker.sock  containrrr/watchtower -c  --schedule "0 0 2 * * *"


聚合地址 http://ip:5002/tv.m3u
央视 http://ip:5002/tptv.m3u
虎牙一起看 http://ip:5002/huyayqk.m3u
斗鱼一起看 http://ip:5002/douyuyqk.m3u
YY轮播 http://ip:5002/yylunbo.m3u
BiliBili http://ip:5002/bililive.m3u
Youtubu http://ip:5002/youtube/cK4LemjoFd0(?quality=1080/720...) 失效
