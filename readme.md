# Magnificent

## Getting Started Notes
### Install LAAMP

     sudo yum install -y httpd24 php56 mysql55-server php56-mysqlnd
     sudo service httpd start
     sudo chckconfig httpd on
         
[Full documentation &rsaquo;](http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/install-LAMP.html)

### Install Git
    sudo yum install git-all

### Clone repo
    git clone <url> <relative directory name>

### Edit http.conf
    nano /etc/httpd.conf
    Allow Override All

### Reboot server
     sudo httpd -k restart

## Command Line Notes

### Change PEM key permissions
    chmod 400 mykey.pem

### Remove directory and child files
    rm -rf mydir

## Who do I talk to?

- [Dino Dogan](mailto:dino.dogan@gmail.com)