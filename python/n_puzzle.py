from grid import get_grid, goal_grid, print_grid, get_grid_size, grid_to_str
from heuristic import manhattan_state
from errors import check_file
from algorithm import create_node, create_child, a_star

def main():
    if check_file() == 0:
        coordinates = get_grid()
        start = create_node(coordinates, "start", 0, 'c')
        a_star(start)
        return 0
    else:
        return 1


if __name__ == "__main__":
    main()
