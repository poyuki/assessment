alias ll='ls -alh'
export PATH=$PATH:~/.composer/vendor/bin:./bin:./vendor/bin:./node_modules/.bin
source ~/.git-completion.bash
source ~/.git-prompt.sh

# for more information on this: https://github.com/pluswerk/php-dev/blob/master/.additional_bashrc.sh
CONTAINER_ID=$(basename $(cat /proc/1/cpuset))
export HOST_DISPLAY_NAME=$HOSTNAME

SUDO=''
if (( $EUID != 0 )); then
   SUDO='sudo'
fi

if [ -e /var/run/docker.sock ]; then
   $SUDO apk add docker
fi
if sudo docker ps -q &>/dev/null; then
  DOCKER_COMPOSE_PROJECT=$(sudo docker inspect ${CONTAINER_ID} | grep '"com.docker.compose.project":' | awk '{print $2}' | tr -d '"' | tr -d ',')
  export NODE_CONTAINER=$(sudo docker ps -f "name=${DOCKER_COMPOSE_PROJECT}_node_1" --format {{.Names}})
  export HOST_DISPLAY_NAME=$(sudo docker inspect ${CONTAINER_ID} --format='{{.Name}}')
  export HOST_DISPLAY_NAME=${HOST_DISPLAY_NAME:1}

  alias node_exec='sudo docker exec -u $(id -u):$(id -g) -w $(pwd) -it ${NODE_CONTAINER}'
  alias node_root_exec='sudo docker exec -w $(pwd) -it ${NODE_CONTAINER}'

  alias node='node_exec node'
  alias npm='node_exec npm'
  alias npx='node_exec npx'
  alias yarn='node_exec yarn'
fi;
export HOST_DISPLAY_NAME=$HOSTNAME

#if [[ $CONTAINER_ID != ${HOSTNAME}* ]] ; then
#  export HOST_DISPLAY_NAME=$HOSTNAME
#fi

PS1='[\u \W]\$ ';
#if [ -z "$SSH_AUTH_SOCK" ] ; then
#  ssh-add -t 604800 ~/.ssh/id_rsa
#fi

function listEnvs() {
  env | grep "^${1}" | cut -d= -f1
}

function getEnvVar() {
  awk "BEGIN {print ENVIRON[\"$1\"]}"
}

function restartPhp() {
  $SUDO supervisorctl -c /opt/docker/supervisord.conf restart php-fpm:php-fpm
}

iniChanged=false;
for ENV_VAR in $(listEnvs "php\."); do
  env_key=${ENV_VAR#php.}
  env_val=$(getEnvVar "$ENV_VAR")
  iniChanged=true

  echo "$env_key = ${env_val}" >> /usr/local/etc/php/conf.d/x.override.php.ini
done

[ $iniChanged = true ] && restartPhp
