# Disclaimer 🚨

This repository is a **quick-and-dirty hack**, not a model project.

- It was thrown together fast, with minimal structure, zero polish, and plenty of shortcuts.
- The code is messy, inconsistent, and absolutely **not** how things should be done in production.
- You’ll find bad naming, duplicated logic, and a general lack of documentation/tests.
- It also reflects the reality of a **badly managed project**, where requirements were constantly pushed to go live *ASAP* with little regard for quality, maintainability, or long-term planning.
- What you see here is the result of a **compromise**: management insisted on shipping a semi-finished solution, and developers were forced to keep hacking on top of it instead of rebuilding things properly.
- This approach was managed under the belief that it would be *cheaper* and *faster*. In reality, it led to the exact opposite: higher costs, more complexity, and slower progress over time.

---

This repo exists as an example of **how a project is *not* supposed to look**.  
If you’re looking for best practices, clean architecture, or maintainable design — this isn’t it.

⚠️ Use at your own risk, laugh at the chaos, and please don’t copy this style into real work.

## Project management software
- [Trello](https://trello.com/b/e4TCBr7E/shntr)

## Environments

- [Production](https://shntr.com)
- [Test](https://test.shntr.com)

## CVS Convention
There are two critical branches

- Master
- Develop

### Develop

This branch's code lives on the test environment. The suggestion is to have two cases of pushing changes to this branch.
- Push directly the changes you're confident about them
- Create your branch, do stuff, make pull request to let coworkers review it

### Master

This branch's code lives on production. 

#### Updates
There are only TWO cases when this branch is being updated
- At a release
- At a hotfix

##### Release
This is regular case when the master is being updated with some new features, bugfixes etc. <br> <br> 
The dynamic of developing the app requires having changes related to some task that is still not ready for going live. <br> <br>
Since that and since we are not having sprints we have to have release branch and pick commits from the develop branch that are related to the tasks ready to go live and then make pull request release -> master.

###### Code versioning 
These are suggestions to make release process smoother as it can be:
- Add task id prefix to a commit related to that task (e.g. `X5b9ci4O - update og image` as it is related to [this task](https://trello.com/c/X5b9ci4O/83-exchange-meta-image))
- Do not solve two or more tickets that have no touching points in one commit.
- Give some meaningful commit message
