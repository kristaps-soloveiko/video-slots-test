## Test for VideoSlots.com

### Contents
1) Running requirements
2) How to run
3) Architecture
4) Comments

### Requirements

* PHP7
* Composer
* Git

### How to run

1) Pull the repo from github
2) Put the code on the VM. 
3) Run Composer install from ROOT
4) Run php public/index.php or feel free to place it on a web server.
 
 ### Architecture
 
 When it comes to making software for casinos, I always try to start with the smallest unit possible. In this case it would 
 have expanded the project massively. So I decided to stay with the smaller scale solution. 
 I made 3 general classes:
 * `RegularSlotGame` - written under the `GameType` interface. Its the game itself and contains properties only describing 
 the general rules to the game. It can be extended or similar games can be added the same way. It has only 2 required methods
 * `GameRoundResult` - This object will always contain the monetary values, pay lines, game results. It does almost no
 logical operations. The main point is to have a strict way of delivering results. In later stages, wrappers over this 
 class would be used for different customers, compliance issues etc.
 * `GameRoundProcessord` - This class serves as the logical gateway. While input does not start from there, all the 
 real actions have a single entryPoint. This class can later be extended quite widely.
 * A few interface and exceptions classes were made. I generally use them a lot. With a well configured IDE, it does 
  help a lot with type hinting, debugging etc.
  
  
  ### Comments
  
  Since no time limit was mentioned, I really did not know the expectations. I tried to keep it all simple and down to
  a minimum. I should have added tests, optimize the winning lines calculation, most possibly use generators for that, 
  do a more advanced application flow. 
  Thank You for Your time


