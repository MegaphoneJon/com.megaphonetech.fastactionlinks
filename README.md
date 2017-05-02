# org.takethestreets.fastactionlinks

Speed up your CiviCRM workflows by adding custom action links to your search results.

With a single click, you can execute one or more actions on a contact.  For instance, add a contact to Group A, remove them from Group B, send an email explaining the change, etc.

### Installation

* Download a copy of the extension from Github and unzip it into your Civi extensions directory. [include link]
* For best results, you'll also want a copy of CiviRules installed.  Use the copy of CiviRules found on my Github [include link] for now; when my changes are merged to the main CiviRules extension, you can use that instead.

### Quick Start

Here's an example that will let you easily add the "Major Donor" tag to a contact from your search results:
* Go to CiviCRM's *Administration menu » Customize Data and Screens » Fast Action Links*.
* Click the "Add Fast Action Link" button.
* Create a new link with an action of "Add a Tag".  Set the label to "Tag as Major Donor".
* Click "Save".
* Now, whenever you use Advanced Search to search for contacts, you'll see a link next to each contact that lets you add a tag.

### Configuration

### Credits
This extension is a project I did with about 30 hours of my own time - no one paid me for this work!  If you benefit from this extension, please consider spending some time engaging in the CiviCRM community.  Attend a meetup, go to CiviCon, answer some new user's question on Stack Exchange.  Thanks!
