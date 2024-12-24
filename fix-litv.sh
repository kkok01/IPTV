#!/bin/bash

# 下载 litv.yaml 文件并复制到指定的 Docker 目录
curl -o /tmp/litv.yaml https://github.com/kkok01/IPTV/blob/main/litv.yaml

# 将文件复制到 Docker 容器内部的指定路径
docker cp /tmp/litv.yaml pixman:/app/app/channel_list/litv.yaml

# 删除临时文件
rm /tmp/litv.yaml

# 重启 Docker 容器
docker restart pixman

# 输出成功信息
echo "litv.yaml 更新成功，Docker 容器已重启。"
