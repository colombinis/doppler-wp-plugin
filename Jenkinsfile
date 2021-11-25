pipeline {
    agent any
    environment{
        ORIGEN_REPO = "git@github.com:colombinis/doppler-wp-plugin.git"
        ORIGEN_BRANCH = "master"
        DESTINO_REPO = "https://plugins.svn.wordpress.org/doppler-form"
        DESTINO_BRANCH = "trunk"
        CURRENT_DIR = $(pwd)
    }
    stages {

        stage('Publish from pull request') {
            when {
                changeRequest target: 'master'
            }
            steps {
                echo "Se realizo el PR en el repo:: ${ORIGEN_REPO}"
            }
        }

        stage('Publish from master') {
            when {
                branch 'master'
            }
            steps {
                echo "Se realizo MERGE en master "                
            }
        }
    }
}
