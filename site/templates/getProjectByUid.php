<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';


function getProjectBySlug(string $pageSlug, Kirby\Cms\App $kirby, Kirby\Cms\Site $site): bool|string
{
  $project = $site->find('projets')->children()->find($pageSlug);

  if($project === null) return json_encode(projectError("Pas de projet sous /$pageSlug"));


  return json_encode([
    "title" =>                 $project->title()->value(),
		"subtitle" =>              $project->subtitle()->value(),
		"cover" =>                 array_values(getImageArrayDataInPage($project->cover()) ?? []),
		"introduction" =>          $project->introduction()->value(),
		"htmlcontent" =>           array_values(
      $project
        ->htmlcontent()
        ->toBlocks()
        ->map(
          function ($item) {

            if ($item->type() == 'image') {

              $arrayImages = getImageArrayDataInPage($item->content()->image());

              return array_merge(
                $item->toArray(),
                [
                  'images' => $arrayImages ? array_values($arrayImages) : [],
                ]
              );
            }

            return $item->toArray();

          }
        )
        ->data()
    ),
		"galleryproject" =>        array_values(
      $project
        ->galleryproject()
        ->toBlocks()
        ->map(
          function ($item) {

            if ($item->type() == 'image') {

              $arrayImages = getImageArrayDataInPage($item->content()->image());

              return array_merge(
                $item->toArray(),
                [
                  'images' => $arrayImages ? array_values($arrayImages) : [],
                ]
              );
            }

            return $item->toArray();

          }
        )
        ->data()
    ),
		"date" =>                  $project->date(),
		"tags" =>                  array_map(function (string $themeSlug) use ($kirby) {
                                  $themePage = $kirby->page($themeSlug);
                                  if ($themePage == null) return null;
                                  return [
                                    'title' => $themePage->title()->value(),
                                    'uid'   => $themePage->uid(),
                                    'uuid'  => $themePage->content()->uuid()->value(),
                                    'uri'   => $themePage->uri(),
                                  ];
                                }, $project->tags()->split()),
		"listofdetails" =>         $project->listofdetails(),
		"uuid" =>                  $project->uuid(),
  ]);
}

function projectError(string $message): array
{
  return [
    'error' => $message,
  ];
}


