==================================
Fivestar Recommender Documentation
==================================

Installation & Configuration
----------------------------

Please read README.txt file in Recommender API first.

After install the module, please go to admin/config/recommender and compute the recommendations. Then you can enable the 4 default views, customize them if necessary, and then display the recommendations.


About this module
-----------------

Fivestar Recommender adds 4 default views:

1. Similar nodes (by votes): It recommends other nodes that are similar to the current node. The recommendations stay the same for the node regardless of the user who views it. "Similarity" is computed based on whether the nodes received the same Fivestar ratings from the users.

2. Recommendations (from similar nodes): It recommends nodes that might interest the current user most, because the user has already highly rated other nodes that are similar to these recommended nodes. Different users will see different recommendations.

3. Similar users (by votes): It shows users who have rated similarly to the current user. This view is useful for online communities to discover users who share similar tastes.

4. Recommendations (from similar users): It recommends nodes that might interest the current user most, because other users who are similar to this user have highly rated these recommended nodes.

The first 2 views are generated using the item-item recommender algorithm, and the last 2 using the user-user recommender algorithm. 1 & 3 are similarity-based recommendations, and 2 & 4 are prediction-based. You can find explanations of the jargons (item-item, user-user, similarity-based, and prediction-based) in Recommender API documentation.

Note: This module only supports `Fivestar <http://drupal.org/project/fivestar>`_ , not other Voting API modules. To enable recommender support for `Vote Up/Down <http://drupal.org/project/vote_up_down>`_ or `Plus 1 <http://drupal.org/project/plus1>`_, please install `Points Voting Recommender <http://drupal.org/project/voting_rec>`_. To support other Voting API modules, you can create new customized modules based on this one.
