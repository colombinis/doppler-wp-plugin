pipeline {
    agent any
    stages {
        stage('Build') {
            environment{
                ORIGEN_REPO = "git@github.com:colombinis/doppler-wp-plugin.git"
                ORIGEN_BRANCH = "master"
                DESTINO_REPO = "https://plugins.svn.wordpress.org/doppler-form"
                DESTINO_BRANCH = "trunk"
                CURRENT_DIR = $(pwd)
            }
            steps {
                echo "getRepoqa()"
                sh '''
                rm -rf repoqa   
                git clone --branch $ORIGEN_BRANCH --single-branch $ORIGEN_REPO repoqa
                '''

                echo "getRepoSVN"
                sh '''
                #borro porque si existe da error el clone
                rm -rf reposvn
                mkdir reposvn
                #svn co = svn checkout
                svn co https://plugins.svn.wordpress.org/doppler-form reposvn
                '''

                echo "updateDestinoFiles()"
                sh '''
                #NOTA el source siempre debe terminar con una barra
                SOURCE="${CURRENT_DIR}/repoqa/src/"
                #NOTA el target no debe terminar con barra
                TARGET="${CURRENT_DIR}/reposvn/trunk/"
                rsync -av --delete --progress --exclude .sass-cache/ $SOURCE $TARGET
                '''

                echo "pushDestinoBranchSVN"
                sh '''
                TARGET="${CURRENT_DIR}/reposvn/"
                cd $TARGET
                # rm -rf tags/$NUEVO_TAG
                # Existe ya la carpeta tag 2.2.6
                # si entonces solo actualizo los archivos a la carpeta existente
                # no actuo como ahora svn add?

                FILE="tags/$NUEVO_TAG"
                if [ -d "$FILE" ] 
                then
                    echo "TAG ALREADY EXISTS. $FILE is a directory."
                    cp -r trunk/* tags/$NUEVO_TAG/
                else
                    echo "NEW TAG: Directory $FILE does not exist."
                    svn cp trunk tags/$NUEVO_TAG
                    svn add tags/$NUEVO_TAG/* --force
                    svn add trunk/* --force
                    echo "Added files."
                fi

                # svn ci -m "update plugin version ${NUEVO_TAG}" --username $WORDPRESS_USERNAME --password $WORDPRESS_PASSWORD
                '''
            }
        }
    }
}
