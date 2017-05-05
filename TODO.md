Create data for testing:
```
drush cvapi FastActionLink.create uf_group_id="1" action_type="addToGroup" action_entity_id=4 label="Advisory Board" hovertext="Test 1" success_message="Contact added to Advisory Board" confirm=1
drush cvapi FastActionLink.create uf_group_id="1" action_type="addToGroup" action_entity_id=2 label="Newsletter" hovertext="Test 2" success_message="Contact subscribed to Newsletter"
drush cvapi FastActionLink.create action_type="addToGroup" action_entity_id=4 label="Default link" hovertext="Test 3" success_message="Contact added to whatever group gid 4 corresponds to."
drush cvapi FastActionLink.create uf_group_id=12 action_type="addToGroup" action_entity_id=4 label="Profile 6 Link" hovertext="Test 4" success_message="Contact added to whatever group gid 12 corresponds to."
drush cvapi FastActionLink.create uf_group_id=12 action_type="civirule" action_entity_id=1 label="CivRule test" hovertext="Test 4" success_message="Civirule fired"
drush cvapi FastActionLink.create uf_group_id="2" action_type="addEntityTag" action_entity_id=3 label="Yes Guv" hovertext="Test 1" success_message="Contact is now tagged as Gov't Agent"
drush cvapi FastActionLink.create uf_group_id="2" action_type="removeEntityTag" action_entity_id=3 label="No Guv" hovertext="Test 2" success_message="Contact is no longer a Gov't Agent"
```


DONE:
* The entity is built
* The API is in place
* The "execute" command works
* we can use alterContent to inject links into search results
* Support hovertext in links
* Create a working link that fires the FAL
* Post-click notifications
* Add a "confirm" dialog on search results
* Post-click dimming
* CiviRules integration
* Handle post-click notifications on error
* More actions besides addToGroup
* Add CiviRulesTrigger when CiviRules is detected
* More comments
* Roll my CiviRule trigger into my own extension, not CiviRules
* Fix CiviRules CiviRuleTrigger.create API
* Revert the code to make entityTypes load dynamically
* Add a menu link
* Add pseudoconstants to the schema
* Create a page for viewing FALs
* Create a form for editing FALs

TODO:
* Fix the weight bug
* Fix this bug when Advanced Searching with no profile:
Notice: Undefined index: hovertext in CRM_Fastactionlinks_BAO_FastActionLink->createFastActionLinkUrl() (line 85 of /home/jon/local/civicrm-buildkit/build/dmaster/sites/all/modules/civicrm/tools/extensions/org.takethestreets.fastactionlinks/CRM/Fastactionlinks/BAO/FastActionLink.php).
* Fix all links showing on Advanced Search with no Search View selected.
* Better documentation
* Update info.xml
* Email (remote) links

Tests:

*Add to Group*
* Create a contact.
* Add an "add to group" action link via API.
* Search for a contact
* Press the link
* User is now in the group.
* Press the link again
* Nothing has changed.

*Remove from Group*
Create a contact.
Create a group.
Add the contact to the group.
Add a "remove from group" action link via API.
Search for a contact
Press the link
User is no longer in the group.
Press the link again
Nothing has changed.

*Two links, correct order*
Create two "add to group" action links.
Ensure they're both present.
Ensure they're in the correct order.

*Two links, ensure action corresponds with the correct link*

*Test the "Search Views Exist" function for the Form UI, both when a search view does and doesn't exist.*

getFastActionLinks()
create 4 links - 2 in profile 1, 1 in profile 2, 1 with no profile
Assert getFastActionLinks(null) returns the 1 appropriate link // This is wrong.  Need to think through this!
Assert getFastActionLinks(1) returns the 2 appropriate links
Assert getFastActionLinks(1) returns them in correct weight order
Assert getFastActionLinks(2) returns the 1 appropriate link
