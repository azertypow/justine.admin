<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getTextIntro(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): bool|string
{

  $arrayImages = getImageArrayDataInPage($site->content()->cover_intro());

  return json_encode([
    'textIntro' => $site->content()->text_intro()->value(),
    'cover_intro' => $arrayImages ? array_values( $arrayImages ) : [],
  ]);
}
