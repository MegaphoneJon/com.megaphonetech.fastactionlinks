# Configuration

The Fast Action Links main screen follows all typical CiviCRM conventions.  Use the Action links (Edit, Enable/Disable, Delete) and the "Add Fast Action Link" button as you would in any other portion of CiviCRM.  Most fields also support in-place editing.

When creating or updating a Fast Action Link (screenshot 1), your options are as follows:

#### Link Text
This is the text that will appear in the search results as a clickable link.
#### Description
An internal description of this link's use.  This only appears on this screen.
#### Search View
This link will display when you select this Search View from the Advanced Search drop-down labeled "Views for Display Contacts".

If this field displays "None Found":
* Go to **Administer menu » Customize Data and Screens » Profiles**.
* Click the "Settings" link next to a profile.
* Check the "Search Views" checkbox and press "Save".
* Repeat for as many profiles as you'd like to have Search Views for.

#### Action
When your link is clicked, it will perform this action.

#### Select a (Group, Tag, or CiviRule)
This is the group, tag or CiviRule that your action will use.

#### Hover Text
This text will display when a user hovers their cursor over the link. It's a good place to put instructions to the user about when the link should be clicked, or what the link does.

#### Success Message
When your action successfully completes, this is the notification your users will see.

#### Dim on Use
If this box is checked, the contact will be visually dimmed when the link is clicked. This helps to indicate which contacts have had an action taken.

#### Confirmation box
If this box is checked, a confirmation dialog box will ask the user to confirm their choice.

#### Order
Use this box to control the order in which the links display in the search results.

#### Is this link active
Uncheck this box to disable the Fast Action Link without deleting it.

Screenshot 1:
![Screenshot of Fast Action Links with sample configuration](img/Selection_143.png)
