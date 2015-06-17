## Prerequisites

Your need a Linux server host installed with:
1.Apache
2.PHP
3.Git 
4.SSH

## Installation

1.SSH to host
```bash
ssh www.your_host_address.com:your_ssh_port
```
2.navigate to your "www" folder
```bash
cd /var/www
```
3.git clone
```bash
git clone https://github.com/orochigalois/SG.git
```
4.Change SG folder permissions to 777
```bash
chmod 777 -R SG
```

## Create your own id & play
1.Create id "foo" by typing this into your favorite Web Browser's address bar(Chrome&Safari are highly recommanded)
```
www.your_host_address.com/SG/m0_CREATE_USER.php?user=foo
```
2.Play this game by typing this into Browser's address bar
```
www.your_host_address.com/SG/index.php?user=foo
```
