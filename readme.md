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
