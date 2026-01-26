Falcon Truck Bodies – Theme Deployment Workflow (GitHub → Hostinger)

This document records exactly where we are right now, what has already been completed, and what needs to be changed later to deploy the theme to LIVE. This file is designed so it can be pasted back into ChatGPT in the future to instantly restore full context.

⸻

1. What This Repository Is
	•	This Git repository contains only the WordPress child theme
	•	It does NOT contain WordPress core, plugins, or uploads
	•	The repo root is the theme folder itself

Verified locally with:

git rev-parse --show-toplevel

Result:

wp-content/themes/molla-child

This means:
	•	Deployments only affect the theme
	•	No risk to the rest of the site

⸻

2. Branch Strategy (IMPORTANT)

We are using three branches:

Branch	Purpose	Deploys To
dev	Local development	Nowhere
staging	Client review	Staging site
main	Approved code	LIVE site (not wired yet)

Current status:
	•	staging branch is live and auto-deploys
	•	main exists but is NOT yet connected to live hosting

⸻

3. Hosting Details (Hostinger)

Staging Server
	•	Domain: stg.falconbodies.com
	•	SSH User: u772682663
	•	SSH Port: 65002

Correct Hostinger Path (Critical)

Hostinger requires the full absolute path:

/home/u772682663/domains/stg.falconbodies.com/public_html/wp-content/themes/molla-child/

Any other path (like /domains/...) will fail.

⸻

4. SSH Setup (Completed)

What Was Done
	1.	Generated SSH key locally
	2.	Added public key to Hostinger → SSH Access
	3.	Added private key to GitHub Actions Secrets

GitHub Secret
	•	Name: SSH_KEY
	•	Value: FULL private key contents

This allows GitHub Actions to SSH into Hostinger securely.

⸻

5. GitHub Actions Workflow (STAGING)

File Location (Correct)

.github/workflows/deploy-staging.yml

This folder MUST live at the repo root, not above or below it.

⸻

deploy-staging.yml (Working Version)

name: Deploy to Staging (Hostinger)

on:
  push:
    branches:
      - staging

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout repository
        uses: actions/checkout@v4

      - name: Setup SSH
        uses: webfactory/ssh-agent@v0.9.0
        with:
          ssh-private-key: ${{ secrets.SSH_KEY }}

      - name: Deploy theme to Hostinger (staging)
        run: |
          rsync -avz --delete \
            --exclude=".git*" \
            -e "ssh -p 65002" \
            ./ \
            u772682663@92.112.191.78:/home/u772682663/domains/stg.falconbodies.com/public_html/wp-content/themes/molla-child/


⸻

6. Current Status (CONFIRMED)
	•	Staging deployment is working
	•	GitHub Actions shows GREEN check
	•	Files sync successfully via rsync + SSH
	•	Theme updates appear on stg.falconbodies.com

⸻

7. How to Deploy to LIVE (WHEN APPROVED)

Step 1: Create Live Workflow

Duplicate the staging workflow:

.github/workflows/deploy-live.yml


⸻

Step 2: Change Branch Trigger

FROM:

branches:
  - staging

TO:

branches:
  - main


⸻

Step 3: Update Live Server Details

Replace:

stg.falconbodies.com

With:

falconbodies.com

Update the server path accordingly:

/home/u772682663/domains/falconbodies.com/public_html/wp-content/themes/molla-child/


⸻

Step 4: Deploy Live

Once approved:

git checkout main
git merge staging
git push origin main

This will:
	•	Trigger the live workflow
	•	Deploy approved code to production

⸻

8. Safety Notes
	•	NEVER deploy directly from dev
	•	Always deploy staging first
	•	Only merge to main after approval
	•	rsync uses --delete so removed files WILL be removed on server

⸻

9. How to Resume Later

To continue later, paste this file into ChatGPT and say:

“We are here. Staging is approved. Help me deploy to live.”

ChatGPT will know exactly what to do.

⸻

END OF FILE