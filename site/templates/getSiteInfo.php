<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getSiteInfo(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): bool|string
{
  return json_encode([
    'tags' => array_values($site->find('/liste-des-tags')->childrenAndDrafts()->map(function ($TagItem) {
      return [
        'title'  => $TagItem->content()->title()->value(),
        'uuid'  => $TagItem->content()->uuid()->value(),
        'uri'   => $TagItem->uri(),
        'slug'  => $TagItem->slug(),
      ];

    })->data()),
    'projectsInfos' => array_values($site->find('/projets')->children()->map(function($projectItem) use ($kirby){
      return [
        'title' => $projectItem->content()->title()->value(),
        'subtitle' => $projectItem->content()->subtitle()->value(),
        'cover' => array_values(getImageArrayDataInPage($projectItem->content()->cover()) ?? []),
        'date' => $projectItem->content()->date()->value(),
        'dateEnd' => $projectItem->content()->dateEnd()->value(),
        'with_dateEnd' => $projectItem->content()->with_dateEnd()->value() === 'true',
        'hidde_in_home' => $projectItem->content()->hidde_in_home()->value() === 'true' || false,
        'tags' => array_map(function (string $themeSlug) use ($kirby) {
          $themePage = $kirby->page($themeSlug);
          if ($themePage == null) return null;
          return [
            'title' => $themePage->title()->value(),
            'uid'   => $themePage->uid(),
            'uuid'  => $themePage->content()->uuid()->value(),
            'uri'   => $themePage->uri(),
          ];
        }, $projectItem->content()->tags()->split()),
        'slug' => $projectItem->slug(),
        'proto' => $projectItem->content()->tags()->split(),
      ];
    })->data()),
  ]);

}

//echo json_encode([
//  'projectsInfos' => $site->children()->map(function ($child) {
//    return [
//      $child->toArray()
//    ]
//    ;
//  }),
//]);
