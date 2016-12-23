# org.takethestreets.fastactionlinks
Speed up your CiviCRM workflows by adding custom action links to your search results.


Link to mockup for Form UI (this may be its own menu item, it may be part of the Profile screen).
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/share
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/view/page/ad64222d5

Create data for testing:
drush cvapi FastActionLink.create uf_group_id="name_and_address" action="addToGroup" action_entity_id=4 label="Advisory Board" hovertext="Test 1"
drush cvapi FastActionLink.create uf_group_id="name_and_address" action="addToGroup" action_entity_id=2 label="Newsletter" hovertext="Test 2" weight=2
drush cvapi FastActionLink.create action="addToGroup" action_entity_id=4 label="Default link" hovertext="Test 3"
drush cvapi FastActionLink.create uf_group_id=6 action="addToGroup" action_entity_id=4 label="Profile 6 Link" hovertext="Test 4"

Next question to answer:  How can I tell hook_links to only fire if the profile is applicable?  It seems like hook_buildForm could tell me.  Maybe abandon hook_links? buildForm stores it in _ufGroupID.
It looks like _contextMenu might have the links?  See line 670 of CRM_Contact_Form_Search.

Maybe we can add them at hook_buildForm and re-sort them at hook_links?  Because _contextMenu doesn't include the primary links.

Tests:
*Add to Group*
Create a contact.
Add an "add to group" action link via API.
Search for a contact
Press the link
User is now in the group.
Press the link again
Nothing has changed.

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

getLinks()
create 4 links - 2 in profile 1, 1 in profile 2, 1 with no profile
Assert getLinks(null) returns the 1 appropriate link
Assert getLinks(1) returns the 2 appropriate links
Assert getLinks(1) returns them in correct weight order
Assert getLinks(2) returns the 1 appropriate link