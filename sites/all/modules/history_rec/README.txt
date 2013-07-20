============================
Browsing History Recommender
============================


Installation & Configuration
----------------------------

Please first follow README.txt file in Recommender API.

After install the module, please go to admin/config/search/recommender/admin and compute the recommendations. Then you can enable the default views, customize them if necessary, and then display the recommendations.

Minimum database privileges in addition to those required by RecommenderAPI module:

GRANT SELECT(uid, nid, timestamp) ON {history} TO recommender_user;


About the module
----------------

This module adds two blocks:
1) Users who browsed this node also browsed
2) Personalized recommendations

To compute recommendations, the module uses {history} which keeps track of 30 days of node browsing history.

