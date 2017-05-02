Link to mockup for Form UI (this may be its own menu item, it may be part of the Profile screen).
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/share
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/view/page/ad64222d5

Create data for testing:
```
drush cvapi FastActionLink.create uf_group_id="name_and_address" action="addToGroup" action_entity_id=4 label="Advisory Board" hovertext="Test 1" success_message="Contact added to Advisory Board" confirm=1
drush cvapi FastActionLink.create uf_group_id="name_and_address" action="addToGroup" action_entity_id=2 label="Newsletter" hovertext="Test 2" weight=2 success_message="Contact subscribed to Newsletter"
drush cvapi FastActionLink.create action="addToGroup" action_entity_id=4 label="Default link" hovertext="Test 3" success_message="Contact added to whatever group gid 4 corresponds to."
drush cvapi FastActionLink.create uf_group_id=12 action="addToGroup" action_entity_id=4 label="Profile 6 Link" hovertext="Test 4" success_message="Contact added to whatever group gid 12 corresponds to."
drush cvapi FastActionLink.create uf_group_id=12 action="civirule" action_entity_id=8 label="CivRule test" hovertext="Test 4" success_message="Contact added to FAL CiviRule test group?"
```

Create a CiviRuleTrigger:
drush cvapi CiviRuleTrigger.create sequential=1 name="fast_action_link" label="Fast Action Link" op="manual" class_name="CRM_Civirules_Trigger_Manual"
    $result = civicrm_api3('CiviRuleTrigger', 'create', array(
      'sequential' => 1,
      'name' => "fast_action_link",
      'label' => "Fast Action Link",
      'op' => "manual",
      'class_name' => "CRM_Civirules_Trigger_Manual",
    ));

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

TODO:
* Add CiviRulesTrigger when CiviRules is detected
* More actions besides addToGroup
* Handle post-click notifications on error
* Email (remote) links
* The whole UI
* A hook to define your own actions
* Revert the code to make entityTypes load dynamically
* Better documentation
* More comments?
* phpunit tests


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
