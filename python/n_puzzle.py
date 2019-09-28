from grid import get_grid, goal_grid, print_grid
from heuristic import manhattan_state
from errors import check_file

def main():
    if check_file() == 0:
        coordinates = get_grid()
        start = manhattan_state(coordinates, 3)
        print(start)
        return 0
    else:
        return 1


if __name__ == "__main__":
    main()
