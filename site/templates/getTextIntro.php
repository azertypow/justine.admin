<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getTextIntro(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): bool|string
{
  return json_encode([
    'textIntro' => $site->content()->text_intro()->value(),
    'cover_intro' => array_values( getImageArrayDataInPage($site->content()->cover_intro()) ),
  ]);
}
