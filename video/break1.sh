#create folders


mkdir uploads/videos/$1/tsfiles
mkdir uploads/videos/$1/m3u8files
echo "$1" >> filenamevalidation.txt
path="uploads/videos/$1/"
ls $path | grep -i .mp4 | sort > test
for i in $(cat test)
do
	name=$(echo $i | rev | cut -f 2- -d '.' | rev) 
	#converting files into ts files
 ffmpeg  -i "$path$i" -loglevel verbose -threads 3 -f hls -hls_time 60 -hls_list_size 99999  -start_number 1 -t 9000 -strict -2 -hls_segment_filename "uploads/videos/$1/tsfiles/$name"%01d.ts "uploads/videos/$1/m3u8files/$name".m3u8
 
done 
#uploading in s3 bucket using ansible
 sudo ansible-playbook multiadd.yml --extra-vars "pathoftsfiles=uploads/videos/$1/tsfiles pathofm3u8files=uploads/videos/$1/m3u8files folder=$1 path2=$1/ pathofotherfiles=uploads/videos/$1/otherFiles"

 rm -r uploads/videos/$1