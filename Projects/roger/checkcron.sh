#!/bin/bash

OG=$(cat /root/.shasum)
CHECK=$(shasum -a 256 /etc/crontab | awk '{print$1}')
CRONCP=/root/.croncp
MAIL=/etc/mail.txt
ROOT=m.ondino@hotmail.fr

if [ -f $MAIL ]
then
        rm -f $MAIL
        touch $MAIL
fi

if [ $OG = $CHECK ]
then
        exit
else
        echo "To: $ROOT" >> $MAIL
        echo "Subject: CRONTAB FILE MODIFIED" >> $MAIL
        echo "From: bibi@mondino\n" >> $MAIL
        echo  "OLD ONE : \n" >> $MAIL
        cat $CRONCP >> $MAIL
        echo "\nNEW ONE : \n" >> $MAIL
        cat /etc/crontab >>$MAIL
        sendmail -t < $MAIL &
		shasum -a 256 /etc/crontab | awk '{print$1}' > /root/.shasum
        cp /etc/crontab /root/.croncp
fi

#crontab -e (root) 0 0 * * * sh /root/checkcron.sh