/*
pancakes

pleased = happy
ask = request
notion = idea
create = make
amazing = incredible
keep = retain
end = stop
slash = cut
*/

USE name_in_synonym;

INSERT INTO images (image_type, image_url)
	VALUE (1, "http://www.ihop.com/-/media/DineEquity/IHop/Images/Menu/MenuItems/Pancakes/Original-Buttermilk-Pancakes/Original_-Buttermilk_Pancakes.ashx");

INSERT INTO puzzle (image_id, puzzle_solution, puzzle_appearance)
	VALUE ((SELECT image_id
		FROM images
		WHERE images.image_url = "http://www.ihop.com/-/media/DineEquity/IHop/Images/Menu/MenuItems/Pancakes/Original-Buttermilk-Pancakes/Original_-Buttermilk_Pancakes.ashx"),
	"pancakes", 1);

INSERT INTO puzzle_line (puzzle_id,
						 puzzle_line_order,
						 pair_id,
						 puzzle_line_column,
						 puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   1,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "pleased" AND pairs.value_name = "happy"),
			   1,
			   1);
			   
INSERT INTO puzzle_line (puzzle_id,
						 puzzle_line_order,
						 pair_id,
						 puzzle_line_column,
						 puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   2,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "ask" AND pairs.value_name = "request"),
			   1,
			   0);

INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   3,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "notion" AND pairs.value_name = "idea"),
			   1,
			   1);			   

INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   4,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "create" AND pairs.value_name = "make"),
			   1,
			   1);			

INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   5,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "amazing" AND pairs.value_name = "incredible"),
			   1,
			   0);					   
			   
INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   6,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "keep" AND pairs.value_name = "retain"),
			   1,
			   0);						   
			   
INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   7,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "end" AND pairs.value_name = "stop"),
			   1,
			   1);		
			   
INSERT INTO puzzle_line (puzzle_id, puzzle_line_order, pair_id, puzzle_line_column, puzzle_line_flip)
		VALUE ((SELECT puzzle_id FROM puzzle WHERE puzzle.puzzle_solution = "pancakes" LIMIT 1),
			   8,
			   (SELECT pair_id FROM pairs WHERE pairs.key_name = "slash" AND pairs.value_name = "cut"),
			   1,
			   1);						   