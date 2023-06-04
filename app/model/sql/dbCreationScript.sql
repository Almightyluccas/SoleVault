CREATE DATABASE csc350;


USE csc350;

CREATE TABLE users (
  customerId INT AUTO_INCREMENT PRIMARY KEY,
  username   VARCHAR(50) NOT NULL ,
  password   VARCHAR(20) NOT NULL
);
CREATE TABLE rememberMeSessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customerId INT NOT NULL ,
  series VARCHAR(255) NOT NULL ,
  token VARCHAR(255) NOT NULL ,
  FOREIGN KEY (customerId) REFERENCES users (customerId)
);

CREATE TABLE products (
  productId   INT PRIMARY KEY AUTO_INCREMENT,
  productName VARCHAR(100)   NOT NULL,
  description VARCHAR(500)   NOT NULL,
  price       DECIMAL(13, 2) NOT NULL,
  imageUrl    VARCHAR(255)   NOT NULL
);

CREATE TABLE cart (
  cartId     INT AUTO_INCREMENT PRIMARY KEY,
  customerId INT            NOT NULL,
  productId  INT            NOT NULL,
  quantity   INT(11)        NOT NULL,
  price      DECIMAL(13, 2) NOT NULL,
  FOREIGN KEY (productId) REFERENCES products (productId),
  FOREIGN KEY (customerId) REFERENCES users (customerId)
);




CREATE TABLE purchase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customerId INT NOT NULL,
    productId INT NOT NULL,
    totalPrice decimal(13,2) NOT NULL,
    quantity INT(11)
) ;


CREATE TABLE discountCodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar (10) NOT NULL ,
    value decimal (3,2) NOT NULL # percentage of discount would be stored in value as a decimal
) ;

INSERT INTO discountCodes  (name,value)
VALUES ('csc350', 0.10) ;

INSERT INTO products(productName, description, price, imageUrl)
VALUES
    ('Jordan 6 "infrared"',
     'The Air Jordan 6 Retro “Black Infrared” features a black upper with infrared accents and a translucent sole.
These sneakers were released in February 2019 and retailed for $200. The design is sleek and stylish, with a classic
silhouette that is perfect for any occasion.',
     220, 'https://i.imgur.com/T5crZUj.jpg'),
    ('Jordan 1 "OG Taxi"',
     'The Air Jordan 1 Retro High OG “Taxi” comes in an all leather build that combines a white base with a yellow
toe box, and some yellow overlays in the heel and ankle area. A contrasting black appears in the toe and lace area,
Swoosh, and Wings logo on the lateral side.',
     190, 'https://i.imgur.com/gT0VfSr.jpg'),
    ('Jordan 1 "UNC Fearless" ',
     'The Jordan 1 Retro High Fearless UNC Chicago is a shoe that pays homage to Michael Jordan’s legacy and the moving
speech he gave during his induction into the Basketball Hall of Fame. This shoe is composed of a white patent leather
upper with red and university blue overlays, black Nike “Swoosh”, white midsole, and a red outsole. ',
     430, 'https://i.imgur.com/96CuVFz.jpg'),
    ('Jordan 1 "Lost and Found"',
     'The Air Jordan 1 Retro High OG “Fearless” pays homage to Michael Jordan’s legacy and the moving speech he gave
during his induction into the Basketball Hall of Fame. This edition is crafted with a glossy patent leather upper
that combines Bulls and UNC colors, elevated with a metallic gold wings logo.',
     460,
     'https://i.imgur.com/got4ezz.jpg'),
    ('Jordan 1 "Bubble Gum"',
     'The Air Jordan 1 Retro High OG SE “Bubble Gum” is made for little kids and features a leather upper
that pairs white quarter panels with an Obsidian colored Swoosh. ',
     180, 'https://i.imgur.com/XhAQR0g.jpg'),
    ('Nike Dunk Low "Disrupt 2"',
     'The Nike Dunk Low Disrupt 2 “Green Snake” for women features a white and off-white colorway with
green snake accents. This shoe is a modern take on the classic Dunk silhouette, with multiple lace-up options
and an extra set of laces to allow for customization.',
     170, 'https://i.imgur.com/Zp4lfRa.jpg'),
    ('Nike SB Dunk "Lobster"',
     'The Nike SB Dunk “Lobster” is a collaboration between Nike SB and Boston-based retailer Concepts. The shoe
was inspired by a lobster dinner and features a soft suede upper dressed in an alternating Pink Clay and Sport Red
color scheme as a nod to the crustacean’s iconic colors1.',
     660, 'https://i.imgur.com/nrdmFO6.jpg'),
    ('Jordan 4 "Military Black"',
     'The Air Jordan 4 Retro “Military Black” showcases the same color blocking and materials featured on the OG
“Military Blue” colorway from 1989. The upper is made of smooth white leather, bolstered with a forefoot overlay
in grey suede. ',
     375, 'https://i.imgur.com/DSfM6q9.jpg'),
    ('Nike SB Dunk "LA Dodgers"',
     'The Nike SB Dunk Low “Los Angeles Dodgers” features a white leather upper with blue overlays and red Swoosh logos.
The shoe features a blue and white color scheme that has shades similar to the traditional blue and white worn by
the MLB’s LA Dodgers.',
     370, 'https://i.imgur.com/a7Dh0sa.jpg'),
    ('Jordan 1 "Starfish"',
     'The Air Jordan 1 Retro High OG “Starfish” for women features a white leather base with contrasting orange overlays
and a high-cut collar in chocolate brown. A woven Nike Air tag embellishes a lightly padded nylon tongue in a vintage
off-white finish.',
     180, 'https://i.imgur.com/QzFSYIK.jpg'),

       ('Air Jordan 4 Retro Thunder',
        'The 2023 Air Jordan 4 Retro Thunder is a re-release of the popular shoe originally launched in 2006.
The upper is made of black nubuck with yellow accents on the eyelets, quarter panel, and lower tongue.',
        150, 'https://i.imgur.com/H2X4g9O.jpg'),
       ('Air Jordan 1 Retro High OG Skyline',
        'The Air Jordan 1 Retro High OG Skyline draws inspiration from a classic image of Michael Jordan in mid-flight,
set against the Chicago skyline and a dusky sky.The shoes feature mismatched pink and lavender gradient overlays, a
white leather base, and black accents on the Swoosh, collar, and lining.',
        120, 'https://i.imgur.com/WSVHm52.jpg'),
       ('The Marvel x Air Jordan 1 Retro High OG Next Chapter',
        'The Marvel x Air Jordan 1 Retro High OG Next Chapter is a collaboration tied to the film "Spider-Man: Across
the Spider-Verse." The shoe pays homage to the multidimensional Spiderman universe.',
        250, 'https://i.imgur.com/c8JRzwm.jpg')
        ,
       ('Rick and Morty x MB.02 Adventures',
        'The Rick and Morty x PUMA MB.02 Adventures is a collaboration between LaMelo Ball and the animated series.
        The signature shoe features a mismatched design, with neon yellow and pink gradient on the right shoe and green
and purple gradient on the left.',
        100, 'https://i.imgur.com/X8dv3Zu.jpg')
        ,
       ('Louis Vuitton x Air Force 1 Low Monogram Damier Pilot Case',
        ' The Louis Vuitton x Air Force 1 Low Monogram Damier Pilot Case are a collaboration between Louis Vuitton
and Jordan to help the environment by recycling while making some fancy shoes.
        Using old thrown away LV bags, you get all the quality of Louis Vuitton products on the go.',
        58000, 'https://i.imgur.com/oNuk3LH.jpg');