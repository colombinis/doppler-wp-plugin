pipeline {
    agent any
    environment{
        ORIGEN_REPO = "git@github.com:colombinis/doppler-wp-plugin.git"
        ORIGEN_BRANCH = "master"
        DESTINO_REPO = "https://plugins.svn.wordpress.org/doppler-form"
        DESTINO_BRANCH = "trunk"
    }
    stages {
        stage('QA Deployment') {
            when {
                branch 'master'
            }
            stages{
                stage('Print INFO') {
                    steps {
                        echo  "destino repo ${DESTINO_REPO}"
                        echo  "destino branch ${DESTINO_BRANCH}"
                    }
                }
                stage('Build') {
                    steps {
                        echo 'Compressing files inside src folder without include src '
                        sh 'tar zcvf doppler-plugin.tar.gz -C ./src .'
                        archiveArtifacts artifacts: 'doppler-plugin.tar.gz'
                    }
                }
                stage('Deploy'){
                    steps {
                        sh '''
                        echo Getting plugins.fromdoppler.com server IP (access inside vpn)
                        export IP=167.172.28.50
                        export USER=scolombini
                        export REMOTE_PRIVATEUSERKEY=~/.ssh/id_rsa_doppler_plugins
                        export REMOTE_PORT=2200
                        export DEPLOYMENT=/home/$USER/deployment
                        echo "Removing old artifact if existst"
                        ssh -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY $USER@$IP -p $REMOTE_PORT 'rm -rf $DEPLOYMENT/*'
                        echo Copy build artifact to server
                        scp -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY -P $REMOTE_PORT doppler-plugin.tar.gz $USER@$IP:$DEPLOYMENT/
                        echo "Extract build artifact"
                        ssh -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY $USER@$IP -p $REMOTE_PORT 'tar zxvf $DEPLOYMENT/doppler-plugin.tar.gz -C $DEPLOYMENT/'
                        echo "remove compress artifact"
                        ssh -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY $USER@$IP -p $REMOTE_PORT 'rm  $DEPLOYMENT/doppler-plugin.tar.gz'
                        echo Copy files on the deployment folder
                        ssh -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY $USER@$IP -p $REMOTE_PORT 'sudo mv $DEPLOYMENT/* /home/sftp/www/html/_shared'
                        echo Change ownership of files
                        ssh -o "StrictHostKeyChecking=no" -i $REMOTE_PRIVATEUSERKEY $USER@$IP -p $REMOTE_PORT 'sudo chown -R www:www-data /home/sftp/www/html/_shared'
                        '''
                    }
                }
            }
        }
        stage('PRD Deployment') {
            when {
                expression {
                    return isVersionTag(readCurrentTag())
                }
            }
            stages{
                stage('Build') {
                    steps {
                        sh '''
                        echo TODO get files from svn
                        echo TODO get files from github
                        echo TODO update files from github to svn
                        echo "el tag encontrado Building $TAG_NAME"
                        '''
                    }
                }
                stage('Deploy'){
                    steps {
                        sh '''
                        echo TODO create a new SVN version 
                        echo TODO take new version and push to svn wordpress
                        '''
                    }
                }
            }
        }
    }
}

def boolean isVersionTag(String tag) {
    echo "checking version tag $tag"

    if (tag == null) {
        return false
    }

    // use your preferred pattern
    def tagMatcher = tag =~ /v\d+\.\d+\.\d+/

    return tagMatcher.matches()
}

def CHANGE_ID = env.CHANGE_ID

def String readCurrentTag() {
    return sh(returnStdout: true, script: "git describe --tags --match v?*.?*.?* --abbrev=0 --exact-match || echo ''").trim()
}