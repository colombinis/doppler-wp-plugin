Permanentemente revisando el repo del plugin https://github.com/MakingSense/doppler-wp-plugin

1-Cuando alguien hace un PR y MERGEA a MASTER branch -> publicar en el servidor por ssh sftp ( plugins.fromdoppler.com)
permisos necesarios: 
 - github.com/MakingSense
 - para subir al filesystem del server plugins.fromdoppler.com

2-Cuando alguien crea un TAG en MASTER -> publicar en el servidor de SVN wordpress
permisos necesarios: 
 - github.com/MakingSense
 - para subir al SVN de wordpress


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
