# seat-wanderer-access-sync
A SeAT plugin to synchronize SeAT roles to wanderer access lists.

## Installation
The normal [package installation](https://eveseat.github.io/docs/community_packages/) steps apply.

The plugin name is `recursivetree/seat-wanderer-access-sync`.


## Why not integrate into seat-connector?
I've tried adding a wanderer connector for seat-connector, but the way wanderer ACLs work don't map well to what seat-connector expects.

For example, seat-connector can only manage users that register their account on the Identities page.

Also, seat-connector expects the driver to present a list of users that the driver can manage and then checks whether they should have access, but you can configure ACLs for any character in wanderer if it is not registered.
It would be more efficient for seat to come up with a list of characters that should have access

While it is possible to build a connector for wanderer ACLs, I believe you can get a better result outside the connector framework.