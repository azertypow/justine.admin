<?php

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getAbout(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $contactPage = $site->find('a-propos');

  if( $contactPage == null ) return [
    'error' => '"a-propos" does\'nt exist',
    'data' => null,
  ];

  return [
    'error' => null,
    'data' => [
      'aboutTitle' => $contactPage->aboutTitle()->value(),
      'textabout' => array_values(
        $contactPage
          ->textabout()
          ->toBlocks()
          ->map(
            function ($item) {

              if ($item->type() == 'image' | $item->type() == 'imageGallery') {

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
      )
    ],
  ];
}
