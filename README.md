# org.takethestreets.fastactionlinks
Speed up your CiviCRM workflows by adding custom action links to your search results.

Data schema WIP:
id
profile_id
action
action_entity_id
is_active
weight
dim_on_use


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
