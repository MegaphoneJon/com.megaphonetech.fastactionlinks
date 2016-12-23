# org.takethestreets.fastactionlinks
Speed up your CiviCRM workflows by adding custom action links to your search results.


Link to mockup for Form UI (this may be its own menu item, it may be part of the Profile screen).
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/share
https://app.moqups.com/badlysocialized@gmail.com/iYCkozdkVv/view/page/ad64222d5

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
