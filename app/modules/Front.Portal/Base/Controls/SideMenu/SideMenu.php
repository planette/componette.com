<?php declare(strict_types = 1);

namespace App\Modules\Front\Portal\Base\Controls\SideMenu;

use App\Model\Database\ORM\EntityModel;
use App\Model\Database\ORM\Tag\Tag;
use App\Model\UI\BaseControl;

final class SideMenu extends BaseControl
{

	/** @var EntityModel */
	private $em;

	public function __construct(EntityModel $em)
	{
		$this->em = $em;
	}

	/**
	 * RENDER ******************************************************************
	 */

	/**
	 * Render siderbar
	 */
	public function render(): void
	{
		$this->template->items = function () {
			$items = $this->em->getRepositoryForEntity(Tag::class)->findAll()->fetchAll();
			usort($items, function ($a, $b) {
				return $a->addons->countStored() < $b->addons->countStored();
			});

			return $items;
		};
		$this->template->setFile(__DIR__ . '/templates/menu.latte');
		$this->template->render();
	}

}
