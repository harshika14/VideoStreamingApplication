#converting video into ts files
echo "$2" >> filenamevalidation.txt
ffmpeg  -i $1 -loglevel verbose -threads 3 -f hls -hls_time 60 -hls_list_size 99999  -start_number 1 -t 9000 -strict -2 -hls_segment_filename  uploads/tsfiles/$2/$2%01d.ts $3
#uploading in s3 bucket using ansible
sudo ansible-playbook multiadd.yml --extra-vars "pathoftsfiles=uploads/tsfiles/$2 pathofm3u8files=uploads/m3u8files/$2 folder=$2 path2=$2/"

#rm -r $1
#rm -r /opt/lampp/htdocs/video/uploads/tsfiles/$2
#rm -r /opt/lampp/htdocs/video/uploads/m3u8files/$2