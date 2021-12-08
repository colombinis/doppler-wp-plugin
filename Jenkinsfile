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
                        echo 'Compressing files inside src folder '
                        sh 'tar zcvf doppler-plugin.tar.gz ./src'
                        archiveArtifacts artifacts: 'doppler-plugin.tar.gz'
                    }
                }
                stage('Deploy'){
                    steps {
                        sh '''
                        echo Getting plugins.fromdoppler.com server IP (access inside vpn)
                        export IP=167.172.28.50
                        echo "Removing deployment folder and old artifact if existst"
                        ssh -o "StrictHostKeyChecking=no" scolombini@$IP 'rm -rf ~/deployment/ ~/doppler-plugin.tar.gz'
                        echo Copy build artifact to server
                        scp -o "StrictHostKeyChecking=no" doppler-plugin.tar.gz scolombini@$IP:~/
                        echo "Create deployment folder"
                        ssh -o "StrictHostKeyChecking=no" scolombini@$IP 'mkdir ~/deployment/'
                        echo "Extract build artifact"
                        ssh -o "StrictHostKeyChecking=no" scolombini@$IP 'tar zxvf doppler-plugin.tar.gz -C ~/deployment/'
                        echo Copy files on the deployment folder
                        ssh -o "StrictHostKeyChecking=no" scolombini@$IP \'sudo cp -rfv deployment/* /home/sftp/www/html/_shared\'
                        echo Change ownership of files
                        ssh -o "StrictHostKeyChecking=no" scolombini@$IP \'sudo chown -R www:www-data /home/sftp/www/html/_shared\'
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