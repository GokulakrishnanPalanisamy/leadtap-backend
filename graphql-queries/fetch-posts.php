<?php

return <<<'GRAPHQL'
        {
          posts {
            edges {
              node {
                databaseId
                title
                content
              }
            }
          }
        }
        GRAPHQL;
