SilverStripe Magic Links
========================

This module adds a temporary :sparkles: magic link :sparkles: to any dataobject that has the `MagicLinkExtension` applied. This can be used to grant temporay access to a File or Page until the link expires (default: 60 minutes).

## Considerations

**This is not especially secure**. If anyone gets a hold of your hash, they will have access to your resource. Period. Additionally, if you create a magic link and someone brute-forces the hash before it expires, they could gain access. **Proceed with caution.**

## Requires

- SilverStripe Framework 4

## TODO

- Tie in with QueuedJobs to prune the DB table to prevent it getting enormous
- Make a nice button to generate the link in the CMS