<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/3/20
 * Time: 4:45 PM
 */

namespace App\Http\Repositories;

/**
 * Interface IRepo
 * @package App\Repositories
 */
interface IRepo {

    /**
     * @return object
     */
    public function model(): object;

    /**
     * @param array $data
     * @return object
     */
    public function create(array $data): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete(int $id);

    /**
     * @param array $clause
     * @return mixed
     */
    public function deleteByClause(array $clause): bool;

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param array $ids
     * @param array $data
     * @return bool
     */
    public function updateMultipleRows(array $ids, array $data): bool;

    /**
     * @param array $clause
     * @param array $data
     * @return bool
     */
    public function updateByClause(array $clause, array $data): bool;

    /**
     * @param int $id
     * @return object
     */
    public function edit(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function findById(int $id): object ;

    /**
     * @param array $clause
     * @return mixed
     */
    public function findByClause(array $clause);
}
