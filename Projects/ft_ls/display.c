/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   display.c                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: nkellum <nkellum@student.42.fr>            +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/05/30 12:02:12 by nkellum           #+#    #+#             */
/*   Updated: 2019/05/30 12:55:13 by nkellum          ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_ls.h"

int	num_length(long long num)
{
	int i;

	i = 0;
	if (num < 0)
	{
		num = -num;
		i++;
	}
	while (num /= 10)
		i++;
	i++;
	return (i);
}

void print_spaces(int num)
{
	int i;

	i = 0;
	while(i < num)
	{
		printf(" ");
		i++;
	}
}

int *get_offsets(t_entry *list_start)
{
	int *offsets;
	t_entry *list_current;

	if((offsets = malloc(sizeof(int) * 3)) == NULL)
		return 0;
	offsets[0] = 0;
	offsets[1] = 0;
	offsets[2] = 0;
	list_current = list_start;
	while(list_current)
	{
		if(num_length(list_current->hard_links) > offsets[0])
			offsets[0] = num_length(list_current->hard_links);
		if(num_length(list_current->size) > offsets[1])
			offsets[1] = num_length(list_current->size);
		if(num_length(list_current->date_day_modified) > offsets[2])
			offsets[2] = num_length(list_current->date_day_modified);
		list_current = list_current->next;
	}
	return offsets;
}

void display_entries(t_entry *list_start)
{
	t_entry *list_current;
	int *offsets;

	offsets = get_offsets(list_start);
	list_current = list_start;
	while(list_current)
	{
		printf("%c%s  ", list_current->is_folder ? 'd' : '-', list_current->rights);
		print_spaces(offsets[0] - (num_length(list_current->hard_links)));
		printf("%d %s  %s  ", list_current->hard_links, list_current->user, list_current->group);
		print_spaces(offsets[1] - (num_length(list_current->size)));
		printf("%d %s", list_current->size, list_current->date_month_modified);
		print_spaces(offsets[2] - (num_length(list_current->date_day_modified)));
		printf(" %d %s %s\n", list_current->date_day_modified,
		list_current->date_time_modified, list_current->name);
		list_current = list_current->next;
	}
	free(offsets);
}
