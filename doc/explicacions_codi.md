#ACCÉS A URL EXTERNA#

Per que Symfony reconeixi una url com a ruta externa se li ha d'especificar el protocol "http".

{% set urlGithub = user.github | slice(0,4) == 'http' ? user.github : 'http://' ~ user.github %}
    <a href="{{ urlGithub }}" target="_blank"><i class="fa fa-github-square"></i></a>

Comprovem si la url porta el protocol i si no el possem.


#ACCÉS A FITXERS (RUTES RELATIVES)#

La manera correcta per a obtenir la ruta relativa es amb:

    {{ asset("post/" ~ article.slug)}}

Hi han moltes formes de fer-ho per sortir del pas, però acaben donant problemes al canviar d'entorn.