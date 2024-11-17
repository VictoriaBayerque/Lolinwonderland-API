<?php
    class Model {
        protected $db;

        public function __construct() {
            $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->_deploy();
        }
        private function _deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql =<<<END
                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";

                CREATE TABLE `authors` (
                `author_id` int(11) NOT NULL,
                `author_name` varchar(100) NOT NULL,
                `author_age` int(3) NOT NULL,
                `author_activity` int(4) NOT NULL,
                `author_img` varchar(250) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `authors` (`author_id`, `author_name`, `author_age`, `author_activity`, `author_img`) VALUES
                (1, 'Sarah J. Mass', 38, 2012, 'sarah j mass.jpg'),
                (2, 'Jennifer L. Armentrout', 44, 2011, 'jennifer l armentrout.jpg'),
                (3, 'Marissa Meyer', 40, 2012, 'marisa meyer.jpg'),
                (5, 'Rebecca Yarros', 43, 2010, 'rebecca yarros.jpg');

                CREATE TABLE `books` (
                `book_id` int(11) NOT NULL,
                `book_name` varchar(100) NOT NULL,
                `book_authorid` int(100) DEFAULT NULL,
                `book_series` varchar(100) NOT NULL,
                `book_seriesnumber` int(11) NOT NULL,
                `book_summary` varchar(5000) NOT NULL,
                `book_img` varchar(250) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `books` (`book_id`, `book_name`, `book_authorid`, `book_series`, `book_seriesnumber`, `book_summary`, `book_img`) VALUES
                (1, 'A court of thorns and roses', 1, 'ACOTAR', 1, 'When nineteen-year-old huntress Feyre kills a wolf in the woods, a beast-like creature arrives to demand retribution. Dragged to a treacherous magical land she only knows about from legends, Feyre discovers that her captor is not truly a beast, but one of the lethal, immortal faeries who once ruled their world.\n\nAs she dwells on his estate, her feelings for the faerie, Tamlin, transform from icy hostility into a fiery passion that burns through every lie and warning she’s been told about the beautiful, dangerous world of the Fae. But an ancient, wicked shadow over the faerie lands is growing, and Feyre must find a way to stop it . . . or doom Tamlin—and his world—forever.\n\nPerfect for fans of Kristin Cashore and George R. R. Martin, this first book in a sexy and action-packed series is impossible to put down!', 'ACOTAR.jpg'),
                (2, 'A court of mist and fury', 1, 'ACOTAR', 2, 'Feyre survived Amarantha’s clutches to return to the Spring Court–but at a steep cost. Though she now has the powers of the High Fae, her heart remains human, and it can’t forget the terrible deeds she performed to save Tamlin’s people.\n\nNor has Feyre forgotten her bargain with Rhysand, High Lord of the feared Night Court. As Feyre navigates its dark web of politics, passion, and dazzling power, a greater evil looms—and she might just be key to stopping it. But only if she can harness her harrowing gifts, heal her fractured soul, and decide how she wishes to shape her future—and the future of a world cleaved in two.\n\nWith millions of copies of A Court of Thorns and Roses sold, Sarah J. Maas’s masterful storytelling brings this second book in her seductive and action-packed series to new heights.', 'ACOMAF.jpg'),
                (3, 'A court of wings and ruin', 1, 'ACOTAR', 3, 'Feyre has returned to the Spring Court, determined to gather information on Tamlin’s actions and learn what she can about the invading king threatening to bring Prythian to its knees. But to do so she must play a deadly game of deceit. One slip may spell doom not only for Feyre, but for her world as well.\n\nAs war bears down upon them all, Feyre must decide whom to trust among the dazzling and lethal High Lords, and hunt for allies in unexpected places.\n\nIn this thrilling third book in the #1 New York Times bestselling series from Sarah J. Maas, the earth will be painted red as armies grapple for power over the one thing that could destroy them all.', 'ACOWAR.jpg'),
                (4, 'From blood and ash', 2, 'Blood and Ash', 1, 'A Maiden…\n\nChosen from birth to usher in a new era, Poppy’s life has never been her own. The life of the Maiden is solitary. Never to be touched. Never to be looked upon. Never to be spoken to. Never to experience pleasure. Waiting for the day of her Ascension, she would rather be with the guards, fighting back the evil that took her family, than preparing to be found worthy by the gods. But the choice has never been hers.\n\nA Duty…\n\nThe entire kingdom’s future rests on Poppy’s shoulders, something she’s not even quite sure she wants for herself. Because a Maiden has a heart. And a soul. And longing. And when Hawke, a golden-eyed guard honor bound to ensure her Ascension, enters her life, destiny and duty become tangled with desire and need. He incites her anger, makes her question everything she believes in, and tempts her with the forbidden.\n\nA Kingdom…\n\nForsaken by the gods and feared by mortals, a fallen kingdom is rising once more, determined to take back what they believe is theirs through violence and vengeance. And as the shadow of those cursed draws closer, the line between what is forbidden and what is right becomes blurred. Poppy is not only on the verge of losing her heart and being found unworthy by the gods, but also her life when every blood-soaked thread that holds her world together begins to unravel.', 'FBAA.jpg'),
                (5, 'Cinder', 3, 'Lunar Chronicles', 1, 'Humans and androids crowd the raucous streets of New Beijing. A deadly plague ravages the population. From space, a ruthless Lunar people watch, waiting to make their move. No one knows that Earth’s fate hinges on one girl. . . . Cinder, a gifted mechanic, is a cyborg.\nShe’s a second-class citizen with a mysterious past, reviled by her stepmother and blamed for her stepsister’s illness. But when her life becomes intertwined with the handsome Prince Kai’s, she suddenly finds herself at the center of an intergalactic struggle, and a forbidden attraction. Caught between duty and freedom, loyalty and betrayal, she must uncover secrets about her past in order to protect her world’s future.', 'Cinder.jpg'),
                (35, 'A Kingdom of Flesh and Fire', 2, 'Blood and Ash', 2, 'A Betrayal…\n\nEverything Poppy has ever believed in is a lie, including the man she was falling in love with. Thrust among those who see her as a symbol of a monstrous kingdom, she barely knows who she is without the veil of the Maiden. But what she does know is that nothing is as dangerous to her as him. The Dark One. The Prince of Atlantia. He wants her to fight him, and that’s one order she’s more than happy to obey. He may have taken her, but he will never have her.\n\nA Choice….\n\nCasteel Da’Neer is known by many names and many faces. His lies are as seductive as his touch. His truths as sensual as his bite. Poppy knows better than to trust him. He needs her alive, healthy, and whole to achieve his goals. But he’s the only way for her to get what she wants—to find her brother Ian and see for herself if he has become a soulless Ascended. Working with Casteel instead of against him presents its own risks. He still tempts her with every breath, offering up all she’s ever wanted. Casteel has plans for her. Ones that could expose her to unimaginable pleasure and unfathomable pain. Plans that will force her to look beyond everything she thought she knew about herself—about him. Plans that could bind their lives together in unexpected ways that neither kingdom is prepared for. And she’s far too reckless, too hungry, to resist the temptation.\n\nA Secret…\n\nBut unrest has grown in Atlantia as they await the return of their Prince. Whispers of war have become stronger, and Poppy is at the very heart of it all. The King wants to use her to send a message. The Descenters want her dead. The wolven are growing more unpredictable. And as her abilities to feel pain and emotion begin to grow and strengthen, the Atlantians start to fear her. Dark secrets are at play, ones steeped in the blood-drenched sins of two kingdoms that would do anything to keep the truth hidden. But when the earth begins to shake, and the skies start to bleed, it may already be too late.', 'KingdomFF.png'),
                (36, 'The Crown of Gilded Bones', 2, 'Blood and Ash', 3, 'She’s been the victim and the survivor…\n\nPoppy never dreamed she would find the love she’s found with Prince Casteel. She wants to revel in her happiness but first they must free his brother and find hers. It’s a dangerous mission and one with far-reaching consequences neither dreamed of. Because Poppy is the Chosen, the Blessed. The true ruler of Atlantia. She carries the blood of the King of Gods within her. By right the crown and the kingdom are hers.\n\nThe enemy and the warrior…\n\nPoppy has only ever wanted to control her own life, not the lives of others, but now she must choose to either forsake her birthright or seize the gilded crown and become the Queen of Flesh and Fire. But as the kingdoms’ dark sins and blood-drenched secrets finally unravel, a long-forgotten power rises to pose a genuine threat. And they will stop at nothing to ensure that the crown never sits upon Poppy’s head.\n\nA lover and heartmate…\n\nBut the greatest threat to them and to Atlantia is what awaits in the far west, where the Queen of Blood and Ash has her own plans, ones she has waited hundreds of years to carry out. Poppy and Casteel must consider the impossible—travel to the Lands of the Gods and wake the King himself. And as shocking secrets and the harshest betrayals come to light, and enemies emerge to threaten everything Poppy and Casteel have fought for, they will discover just how far they are willing to go for their people—and each other.\n\nAnd now she will become Queen…', 'ThecrownGB.jpg'),
                (37, 'Scarlet', 3, 'Lunar Chronicles', 2, 'She’s trying to break out of prison—even though if she succeeds, she’ll be the Commonwealth’s most wanted fugitive...', 'MMscarlet.jpg'),
                (38, 'Cress', 3, 'Lunar Chronicles', 3, 'Together, they’re plotting to overthrow Queen Levana and prevent her army from invading Earth. Their best hope lies with Cress...', 'MMcress.jpg'),
                (39, 'Heartless', 3, 'Heartless', 1, 'Long before she was the terror of Wonderland — the infamous Queen of Hearts — she was just a girl who wanted to fall in love...', 'MMHeartless.jpg'),
                (40, 'Throne of Glass', 1, 'Throne of Glass', 1, 'In a land without magic, an assassin is summoned to the castle. She has no love for the vicious king who rules from his throne of glass, but she has not come to kill him. She has come to win her freedom. If she defeats twenty-three murderers, thieves, and warriors in a competition, she will be released from prison to serve as the King’s Champion.\n\nHer name is Celaena Sardothien.\n\nThe Crown Prince will provoke her. The Captain of the Guard will protect her. And a princess from a faraway country will befriend her. But something rotten dwells in the castle, and it’s there to kill. When her competitors start dying mysteriously, one by one, Celaena’s fight for freedom becomes a fight for survival-and a desperate quest to root out the evil before it destroys her world.', 'SJMTOG.jpg'),
                (41, 'Fourth Wing', 5, 'Fourth Wing', 1, 'A dragon without its rider is a tragedy. A rider without their dragon is dead. Twenty-year-old Violet Sorrengail was supposed to enter the Scribe Quadrant, living a quiet life among books and history...', 'FourthWingRY.png'),
                (42, 'Crown of Midnight', 1, 'Throne of Glass', 2, 'Celaena Sardothien won a brutal contest to become the King’s Champion. But she is far from loyal to the crown...', 'SJMCOM.jpg'),
                (43, 'Iron Flame', 5, 'Fourth Wing', 2, 'Celaena Sardothien won a brutal contest to become the King’s Champion. But she is far from loyal to the crown', 'RYIronFlame.png'),
                (78, 'Onyx Storm', 5, 'Fourth Wing', 3, 'After nearly eighteen months at Basgiath War College, Violet Sorrengail knows there’s no more time for lessons.\r\nNo more time for uncertainty.\r\nBecause the battle has truly begun; and with enemies closing in from outside their walls and within their ranks, it’s impossible to know who to trust.\r\nNow Violet must journey beyond the failing Aretian wards to seek allies from unfamiliar lands to stand with Navarre.\r\nThe trip will test every bit of her wit, luck, and strength, but she will do anything to save what she loves - her dragons, her family, her home, and him.\r\nEven if it means keeping a secret so big, it could destroy everything.\r\nThey need an army.\r\nThey need power.\r\nThey need magic.\r\nAnd they need the one thing only Violet can find—the truth.\r\nBut a storm is coming... and not everyone can survive its wrath.', '6739fff04d8d0.jpg'),
                (79, 'A court of Frost and Starlight', 1, 'ACOTAR', 4, 'Feyre, Rhys and their friends are still busy rebuilding the Night Court and the vastly changed world beyond. But the Winter Solstice is finally near, and with it a hard-earned reprieve. Yet even the festive atmosphere can’t keep the shadows of the past from looming. As Feyre navigates her first Winter Solstice as High Lady, she finds that those dearest to her have more wounds than she anticipated—scars that will have a far-reaching impact on the future of their court.', '673a04ffce179.jpg'),
                (80, 'A Court of Silver Flames', 1, 'ACOTAR', 5, 'Nesta Archeron has always been prickly—proud, swift to anger, and slow to forgive. And ever since being forced into the Cauldron and becoming High Fae against her will, she’s struggled to find a place for herself within the strange, deadly world she inhabits. Worse, she can’t seem to move past the horrors of the war with Hybern and all she lost in it.\r\n\r\nThe one person who ignites her temper more than any other is Cassian, the battle-scarred warrior whose position in Rhysand and Feyre’s Night Court keeps him constantly in Nesta’s orbit. But her temper isn’t the only thing Cassian ignites. The fire between them is undeniable, and only burns hotter as they are forced into close quarters with each other.\r\n\r\nMeanwhile, the treacherous human queens who returned to the Continent during the last war have forged a dangerous new alliance, threatening the fragile peace that has settled over the realms. And the key to halting them might very well rely on Cassian and Nesta facing their haunting pasts.\r\n\r\nAgainst the sweeping backdrop of a world seared by war and plagued with uncertainty, Nesta and Cassian battle monsters from within and without as they search for acceptance—and healing—in each other’s arms.', '673a058579d98.jpg'),
                (81, 'The War of Two Queens', 2, 'Blood and Ash', 4, 'War is only the beginning…\r\n\r\nFrom number one New York Times best-selling author Jennifer L. Armentrout comes book four in her Blood and Ash series.\r\n\r\nFrom the desperation of golden crowns…\r\n\r\nCasteel Da’Neer knows all too well that very few are as cunning or vicious as the Blood Queen, but no one, not even him, could’ve prepared for the staggering revelations. The magnitude of what the Blood Queen has done is almost unthinkable.\r\n\r\nAnd born of mortal flesh…\r\n\r\nNothing will stop Poppy from freeing her King and destroying everything the Blood Crown stands for. With the strength of the Primal of Life’s guards behind her, and the support of the wolven, Poppy must convince the Atlantian generals to make war her way – because there can be no retreat this time. Not if she has any hope of building a future where both kingdoms can reside in peace.\r\n\r\nA great primal power rises…\r\n\r\nTogether, Poppy and Casteel must embrace traditions old and new to safeguard those they hold dear – to protect those who cannot defend themselves. But war is only the beginning. Ancient primal powers have already stirred, revealing the horror of what began eons ago. To end what the Blood Queen has begun, Poppy might have to become what she has been prophesied to be – what she fears the most.\r\n\r\nAs the Harbinger of Death and Destruction.', '673a071a34bf3.jpg'),
                (82, 'A Soul of Ash and Blood', 2, 'Blood and Ash', 5, 'Only his memories can save her…\r\n\r\nA great primal power has risen. The Queen of Flesh and Fire has become the Primal of Blood and Bone—the true Primal of Life and Death. And the battle Casteel, Poppy, and their allies have been fighting has only just begun. Gods are awakening across Iliseeum and the mortal realm, readying for the war to come. But when Poppy falls into stasis, Cas faces the very real possibility that the dire, unexpected consequences of what she is becoming could take her away from him. Cas is given some advice, though — something he plans to cling to as he waits to see her beautiful eyes open once more:\r\n\r\nTalk to her.\r\n\r\nAnd so, he does. He reminds Poppy how their journey began, revealing things about himself that only Kieran knows in the process. But it’s anybody’s guess what she’ll wake to or exactly how much of the realm and Cas will have changed when she does.', '673a0751b380f.jpg'),
                (83, 'The Primal of Blood and Bone', 2, 'Blood and Ash', 6, 'In the shadows and flames, Primals will fall…\r\nAnd from the blood and ash, new gods will rise.\r\nIn the thrilling penultimate chapter of the viral BLOOD AND ASH series by #1 New York Times\r\nbestselling author Jennifer L. Armentrout, Poppy and Casteel face their most perilous\r\nchallenges yet as old enemies rise and ancient powers stir from their slumber.\r\nBound by love but driven by destiny, they must navigate a world on the brink of\r\ndevastation—where every choice has deadly consequences. With their bond tested and their\r\nfuture hanging in the balance, the fate of the realm rests on the strength of their hearts and the\r\npower of the Deminyen.', '673a079dba1ed.jpg'),
                (84, 'A Shadow in the Ember', 2, 'The Flesh and Fire', 1, 'Born shrouded in the veil of the Primals, a Maiden as the Fates promised, Seraphena Mierel’s future has never been hers. Chosen before birth to uphold the desperate deal her ancestor struck to save his people, Sera must leave behind her life and offer herself to the Primal of Death as his Consort. \r\n\r\nHowever, Sera’s real destiny is the most closely guarded secret in all of Lasania—she’s not the well protected Maiden but an assassin with one mission—one target. Make the Primal of Death fall in love, become his weakness, and then…end him. If she fails, she dooms her kingdom to a slow demise at the hands of the Rot.\r\n\r\nSera has always known what she is. Chosen. Consort. Assassin. Weapon. A specter never fully formed yet drenched in blood. A monster. Until him. Until the Primal of Death’s unexpected words and deeds chase away the darkness gathering inside her. And his seductive touch ignites a passion she’s never allowed herself to feel and cannot feel for him. But Sera has never had a choice. Either way, her life is forfeit—it always has been, as she has been forever touched by Life and Death.', 'AShadowInTheEmbe.jpg'),
                (85, 'Heir of Fire', 1, 'Throne of Glass', 3, 'Celaena Sardothien has survived deadly contests and shattering heartbreak, but now she must travel to a new land to confront her darkest truth. That truth could change her life-and her future-forever.\r\n\r\nMeanwhile, monstrous forces are gathering on the horizon, intent on enslaving her world. To defeat them, Celaena will need the strength not only to fight the evil that is about to be unleashed but also to harness her inner demons. If she is to win this battle, she must find the courage to face her destiny-and burn brighter than ever before.', '673a0883e1967.jpg'),
                (86, 'Queen of Shadows', 1, 'Throne of Glass', 4, 'Celaena Sardothien has embraced her identity as Aelin Galathynius, Queen of Terrasen. But before she can reclaim her throne, she must fight.\r\n\r\nShe will fight for her cousin, a warrior prepared to die for her. She will fight for her friend, a young man trapped in an unspeakable prison. And she will fight for her people, enslaved to a brutal king and awaiting their lost queen’s triumphant return.\r\n\r\nEveryone Aelin loves has been taken from her. Everything she holds dear is in danger. But she has the heart of a queen-and that heart beats for vengeance.', '673a08dcc9745.jpg'),
                (87, 'Empire of Storms', 1, 'Throne of Glass', 5, 'The long path to the throne has only just begun for Aelin Galathynius as war looms on the horizon. Loyalties have been broken and bought, friends have been lost and gained, and those who possess magic find themselves increasingly at odds with those who don’t.\r\n\r\nWith her heart sworn to the warrior-prince by her side and her fealty pledged to the people she is determined to save, Aelin will delve into the depths of her power to protect those she loves. But as monsters emerge from the horrors of the past, dark forces stand poised to claim her world. The only chance for salvation lies in a desperate quest that may take more from Aelin than she has to give, a quest that forces her to choose what-and who-she’s willing to sacrifice for the sake of peace.', '673a0908a6aa4.jpg'),
                (88, 'Winter', 3, 'Lunar Chronicles', 4, 'Together with the cyborg mechanic, Cinder, and her allies, Winter might even have the power to launch a revolution and win a war that’s been raging for far too long. Can Cinder, Scarlet, Cress, and Winter defeat Levana and find their happily ever afters?', '673a099169dc3.jpg'),
                (89, 'Fairest', 3, 'Lunar Chronicles', 5, 'Mirror, mirror, on the wall, Who is the fairest of them all? Fans of the Lunar Chronicles know Queen Levana as a ruler who uses her “glamour” to gain power. But long before she crossed paths with Cinder, Scarlet, and Cress, Levana lived a very different story—a story that has never been told … until now.', '673a09e22302d.jpg'),
                (90, 'Stars Above', 3, 'Lunar Chronicles', 6, 'A prequel of different stories. The Keeper: A prequel to the Lunar Chronicles, showing a young Scarlet and how Princess Selene came into the care of Michelle Benoit. Glitches: In this prequel to Cinder, we see the results of the plague play out, and the emotional toll it takes on Cinder. Something that may, or may not, be a glitch…. The Queen’s Army: In this prequel to Scarlet, we’re introduced to the army Queen Levana is building, and one soldier in particular who will do anything to keep from becoming the monster they want him to be. Carswell’s Guide to Being Lucky: Thirteen-year-old Carswell Thorne has big plans involving a Rampion spaceship and a no-return trip out of Los Angeles. After Sunshine Passes By: In this prequel to Cress, we see how a nine-year-old Cress ended up alone on a satellite, spying on Earth for Luna. The Princess and the Guard: In this prequel to Winter, we see a young Winter and Jacin playing a game called the Princess and the Guard… The Little Android: A retelling of Hans Christian Andersen’s “The Little Mermaid,” set in the world of The Lunar Chronicles. The Mechanic: In this prequel to Cinder, we see Kai and Cinder’s first meeting from Kai’s perspective. Something Old, Something New: In this epilogue to Winter, friends gather for the wedding of the century…', '673a0a2f9382b.jpg'),
                (91, 'House of Earth and Blood', 1, 'Crescent City', 1, 'Bryce Quinlan had the perfect life—working hard all day and partying all night—until a demon murdered her closest friends, leaving her bereft, wounded, and alone. When the accused is behind bars but the crimes start up again, Bryce finds herself at the heart of the investigation. She’ll do whatever it takes to avenge their deaths.\r\n\r\nHunt Athalar is a notorious Fallen angel, now enslaved to the Archangels he once attempted to overthrow. His brutal skills and incredible strength have been set to one purpose—to assassinate his boss’s enemies, no questions asked. But with a demon wreaking havoc in the city, he’s offered an irresistible deal: help Bryce find the murderer, and his freedom will be within reach.\r\n\r\nAs Bryce and Hunt dig deep into Crescent City’s underbelly, they discover a dark power that threatens everything and everyone they hold dear, and they find, in each other, a blazing passion—one that could set them both free, if they’d only let it.', '673a0b2e26819.jpg'),
                (92, 'House of Sky and Breath', 1, 'Crescent City', 2, 'Bryce Quinlan and Hunt Athalar are trying to get back to normal—they may have saved Crescent City, but with so much upheaval in their lives lately, they mostly want a chance to relax. Slow down. Figure out what the future holds.\r\n\r\nThe Asteri have kept their word so far, leaving Bryce and Hunt alone. But with the rebels chipping away at the Asteri’s power, the threat the rulers pose is growing. As Bryce, Hunt, and their friends get pulled into the rebels’ plans, the choice becomes clear: stay silent while others are oppressed or fight for what’s right. And they’ve never been very good at staying silent.', '673a0b6fc37bf.jpg'),
                (93, 'A Light in the Flame', 2, 'The Flesh and Fire', 2, 'The only one who can save Sera now is the one she spent her life planning to kill.\r\n\r\nThe truth about Sera’s plan is out, shattering the fragile trust forged between her and Nyktos. Surrounded by those distrustful of her, all Sera has is her duty. She will do anything to end Kolis, the false King of Gods, and his tyrannical rule of Iliseeum, thus stopping the threat he poses to the mortal realm.\r\n\r\nNyktos has a plan, though, and as they work together, the last thing they need is the undeniable, scorching passion that continues to ignite between them. Sera cannot afford to fall for the tortured Primal, not when a life no longer bound to a destiny she never wanted is more attainable than ever. But memories of their shared pleasure and unrivaled desire are a siren’s call impossible to resist.\r\n\r\nAnd as Sera begins to realize that she wants to be more than a Consort in name only, the danger surrounding them intensifies. The attacks on the Shadowlands are increasing, and when Kolis summons them to Court, a whole new risk becomes apparent. The Primal power of Life is growing inside her, pushing her closer to the end of her Culling. And without Nyktos’s love—an emotion he’s incapable of feeling—she won’t survive her Ascension. That is if she even makes it to her Ascension and Kolis doesn’t get to her first. Because time is running out. For both her and the realms.', '673a0c63e9f65.jpg'),
                (94, 'Fall of Ruin and Wrath', 2, 'The Awakening', 1, 'She lives by her intuition. He feeds on her pleasure.\r\n\r\nLong ago, the world was destroyed by gods. Only nine cities were spared. Separated by vast wilderness teeming with monsters and unimaginable dangers, each city is now ruled by a guardian―royalty who feed on mortal pleasure.\r\n\r\nBorn with an intuition that never fails, Calista knows her talents are of great value to the power-hungry of the world, so she lives hidden as a courtesan of the Baron of Archwood. In exchange for his protection, she grants him information.\r\n\r\nWhen her intuition leads her to save a traveling prince in dire trouble, the voice inside her blazes with warning―and promise. Today he’ll bring her joy. One day he’ll be her doom.\r\n\r\nWhen the Baron takes an interest in the traveling prince and the prince takes an interest in Calista, she becomes the prince’s temporary companion. But the city simmers with rebellion, and with knights and monsters at her city gates and a hungry prince in her bed, intuition may not be enough to keep her safe.\r\n\r\nCalista must choose: follow her intuition to safety or follow her heart to her downfall.', '673a0cd9ccd6f.jpg'),
                (95, 'A Fire in the Flesh', 2, 'The Flesh and Fire', 3, 'The only thing that can save the realms now is the one thing more powerful than the Fates.\r\n\r\nAfter a startling betrayal ends with both Sera and the dangerously seductive ruler of the Shadowlands she has fallen madly in love with being held captive by the false King of the Gods, there is only one thing that can free Nyktos and prevent the forces of the Shadowlands from invading Dalos and igniting a War of Primals.\r\n\r\nConvincing Kolis won’t be easy, though – not even with a lifetime of training. While his most favored Revenant is insistent that she is nothing more than a lie, Kolis’s erratic nature and twisted sense of honor leave her shaken to the core, and nothing could’ve prepared her for the cruelty of his Court or the shocking truths revealed. The revelations not only upend what she has understood about her duty and the very creation of the realms but also draw into question exactly what the true threat is. However, surviving Kolis is only one part of the battle. The Ascension is upon her, and Sera is out of time.\r\n\r\nBut Nyktos will do anything to keep Sera alive and give her the life she deserves. He’ll even risk the utter destruction of the realms, and that’s exactly what will happen if he doesn’t Ascend as the Primal of Life. Yet despite his desperate determination, their destinies may be out of their hands.\r\n\r\nBut there is that foreseen unexpected thread—the unpredictable, unknown, and unwritten. The only thing more powerful than the Fates…', '673a0d13437f4.jpg'),
                (96, 'House of Flame and Shadow', 1, 'Crescent City', 3, 'Bryce Quinlan never expected to see a world other than Midgard, but now that she has, all she wants is to get back. Everything she loves is in Midgard: her family, her friends, her mate. Stranded in a strange new world, she iss going to need all her wits about her to get home again. And that is no easy feat when she has no idea who to trust.\r\n\r\nHunt Athalar has found himself in some deep holes in his life, but this one might be the deepest of all. After a few brief months with everything he ever wanted, he is in the Asteris dungeons again, stripped of his freedom and without a clue as to Bryces fate. He is desperate to help her, but until he can escape the Asteris leash, his hands are quite literally tied.', '673a0d637f8b8.jpg'),
                (97, 'Tower of Down', 1, 'Throne of Glass', 6, 'Chaol Westfall and Nesryn Faliq have arrived in the shining city of Antica to forge an alliance with the Khagan of the Southern Continent, whose vast armies are Erilea’s last hope. But they have also come to Antica for another purpose: to seek healing at the famed Torre Cesme for the wounds Chaol received in Rifthold.\r\n\r\nAfter enduring unspeakable horrors as a child at the hands of Adarlanian soldiers, Yrene Towers has no desire to help the young lord from Adarlan, let alone heal him. Yet she has sworn an oath to assist those in need, and she will honor it. But Lord Westfall carries his own dark past, and Yrene soon realizes that those shadows could engulf them both.\r\n\r\nChaol, Nesryn, and Yrene will have to draw on every scrap of their resilience to overcome the danger that surrounds them. But while they become entangled in the political webs of the khaganate, long-awaited answers slumber deep in the mountains, where warriors soar on legendary ruks. Answers that might offer their world a chance at survival . . . or doom them all.', '673a0dcf62df9.jpg'),
                (98, 'Born of Blood And Ash', 2, 'The Flesh and Fire', 4, 'The line between love and obsession has never been wider.  \r\nWhile Sera is finally free of Kolis and back with those she loves, not everything is calm. Memories of all she’s endured still haunt her, but Sera finally has hope for a future with the other half of her heart and soul. Nyktos desires, loves, and accepts every part of her—even the monstrous bits she still battles.\r\n\r\nMore than ever, Sera and Ash have everything under the realms to fight for, and Nyktos has no doubt Sera is fit to be the Queen of the Gods. But she must find that faith within herself if they hope to convince the other Courts to support them against Kolis and make Iliseeum and the mortal realm better, safer places for all.\r\n\r\nBut as Sera begins to piece together the importance of her bloodline and the true meaning behind the foreboding prophecy, it becomes clear that everything that has happened and is yet to come is much bigger than Kolis and his dark obsessions.\r\n\r\nThey cannot help but wonder exactly how much influence the Fates have had and what their ultimate goal is. What Sera does know for sure is that they can trust very few—including her.\r\n\r\nA battle between the gods is brewing, and heartbreaking losses are imminent with the true Primal of Death strengthening. With a family of the heart willing to battle by their side, can Sera and Nyktos stop Kolis before he destroys the realms, or will it all disappear in a fiery inferno of blood and ash?\r\n\r\nAnd the line between justice and vengeance has never been so thin.', '673a0e12de62c.jpg'),
                (99, 'Kingdom of Ash', 1, 'Throne of Glass', 7, 'Aelin Galathynius has vowed to save her people—but at a tremendous cost. Locked in an iron coffin by the Queen of the Fae, Aelin must draw upon her fiery will as she endures months of torture. The knowledge that yielding to Maeve will doom those she loves keeps her from breaking, but her resolve unravels with each passing day.\r\n\r\nWith Aelin captured, her friends and allies have scattered. Some bonds will grow even deeper, while others will be severed forever. But as destinies weave together at last, all must stand together if Erilea is to have any hope of salvation.\r\n\r\nSarah J. Maas’s #1 New York Times bestselling Throne of Glass series draws to an explosive conclusion as Aelin fights for her life, her people, and the promise of a better world.', '673a0eac684a8.jpg'),
                (100, 'Storm and Fury', 2, 'The Harbinger', 1, 'Eighteen-year-old Trinity Marrow may be going blind, but she can see and communicate with ghosts and spirits. Her unique gift is part of a secret so dangerous that she’s been in hiding for years in an isolated compound fiercely guarded by Wardens—gargoyle shape-shifters who protect humankind from demons. If the demons discover the truth about Trinity, they’ll devour her, flesh and bone, to enhance their own powers.\r\n\r\nWhen Wardens from another clan arrive with disturbing reports that something out there is killing both demons and Wardens, Trinity’s safe world implodes. Not the least because one of the outsiders is the most annoying and fascinating person she’s ever met. Zayne has secrets of his own that will upend her world yet again—but working together becomes imperative once demons breach the compound and Trinity’s secret comes to light. To save her family and maybe the world, she’ll have to put her trust in Zayne. But all bets are off as a supernatural war is unleashed….', '673a0f08db78f.jpg'),
                (101, 'Rage and Ruin', 2, 'The Harbinger', 2, 'Forbidden alliances, forbidden love.\r\nA half human, half angel and her bonded gargoyle protector must work with demons to stop the apocalypse while avoiding falling in love. The Harbinger is coming…but who or what is it? All of humankind may fall if Trinity and Zayne can’t win the race against time as dark forces gather.\r\n\r\nAs tensions rise, they must stay close together and patrol the DC streets at night, seeking signs of the Harbinger, an entity that is killing Wardens and demons with no seeming rhyme or reason.\r\n\r\nForbidden to be with each other, Zayne and Trinity fight their feelings and turn to unusual sources for help—the demon Roth and his cohorts. But as deaths pile up and they uncover a sinister plot involving the local high school and endangering someone dear to Zayne, Trin realizes she is being led…herded…played for some unknown end. As anger builds and feelings spiral out of control, it becomes clear that rage may be the ruin of them all.', '673a0f3f8f078.jpg'),
                (102, 'Grace and Glory', 2, 'The Harbinger', 3, 'When Angels Fall.\r\n\r\nTrinity Marrow has lost the battle and her beloved Protector. Even with both demons and Wardens on her side, Trin may not win the war against the Harbinger.\r\n\r\nBringing Lucifer back to the world to fight the Harbinger is probably a really, really bad idea, but they’re out of options—and the world’s ultimate fallen angel is the only being powerful enough to impact the outcome.\r\n\r\nAs Trin and Zayne form a new and more dangerous bond and Lucifer unleashes Hell on earth, the apocalypse looms and the world teeters on the end of forever. Win or lose, one thing is certain—nothing will ever be the same.', '673a0f7222c2c.jpg');

                CREATE TABLE `users` (
                `user_id` int(11) NOT NULL,
                `user_name` varchar(100) NOT NULL,
                `user_lastname` varchar(100) NOT NULL,
                `user_email` varchar(200) NOT NULL,
                `user_username` varchar(50) NOT NULL,
                `user_password` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `users` (`user_id`, `user_name`, `user_lastname`, `user_email`, `user_username`, `user_password`) VALUES
                (1, 'Victoria', 'Bayerque', 'tori.bayerque@gmail.com', 'ladypanther', '$2y$10$jxhcmkOgwyLrCzMLdP1wKuchsroA.S.Fqw9bTg.ooTPVemQROLTYi'),
                (2, 'Web2', 'Web2', 'web2@web2.com', 'webadmin', '$2y$10$1p9TGjfHmB2Bm48ZF0oTGe7pRH0v0yus0aljTvScBwAhm4NmAPdRy'),
                (3, 'Victoria', 'Bayerque', 'lola@gmail.com', 'blackcat', '$2y$10$7hmBNuXykXsjFMIbhPgaauZcLUTd4txR3iVS2.jEKkCJEj69knVu.');


                ALTER TABLE `authors`
                ADD PRIMARY KEY (`author_id`),
                ADD UNIQUE KEY `author_name` (`author_name`);

                ALTER TABLE `books`
                ADD PRIMARY KEY (`book_id`,`book_name`),
                ADD KEY `book_authorid` (`book_authorid`);

                ALTER TABLE `users`
                ADD PRIMARY KEY (`user_id`),
                ADD UNIQUE KEY `user_email` (`user_email`),
                ADD UNIQUE KEY `user_username` (`user_username`);

                ALTER TABLE `authors`
                MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

                ALTER TABLE `books`
                MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

                ALTER TABLE `users`
                MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

                ALTER TABLE `books`
                ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`book_authorid`) REFERENCES `authors` (`author_id`);
                
                COMMIT;
                END;
                $this->db->query($sql);
            }
        }
    
    }