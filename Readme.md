SilverStripe Magic Links
========================

This module adds a temporary :sparkles: magic link :sparkles: to any dataobject that has the `MagicLinkExtension` applied. This can be used to grant temporay access to a File or Page until the link expires (default: 60 minutes).

## Requires

- SilverStripe Framework 4

## TODO

- Tie in with QueuedJobs to prune the DB table to prevent it getting enormous
- Make a nice button to generate the link in the CMS